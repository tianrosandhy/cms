<?php
namespace App\Core\Providers;

use App\Core\Base\Providers\BaseServiceProvider;
use App\Core\Models\Language;
use App\Core\Models\Role;
use App\Core\Models\Setting;
use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Sidebar;
use Setting as SettingFacade;
use Exception;
use App\Core\Components\Themes;

class CoreServiceProvider extends BaseServiceProvider
{
    protected $namespace = 'App\Core\Http\Controllers';

    public function boot()
    {
        Builder::defaultStringLength(191);
        $this->loadMigrationsFrom(realpath(__DIR__ . "/../Migrations"));
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/Translations', 'core');
        View::composer('*', function($view){
            $current_user = request()->get('user');
            if ($current_user) {
                $view->with('user', $current_user)
                    ->with('sidebar', Sidebar::generate())
                    ->with('setting', SettingFacade::data());
            }
        });

        $theme = new Themes;
        if ($theme->validTheme()) {
            $this->loadViewsFrom($theme->layoutPath(), 'themes');
        }

    }

    public function register()
    {
        $this->loadHelpers(__DIR__ . '/..');
        $this->mapping($this->app->router);
        $this->loadViewsFrom(realpath(__DIR__ . "/../Resources/Views"), 'core');
        $this->loadModules();
        $this->mergeMainConfig();
        $this->registerAlias();
        $this->registerContainer();

        // share view globally
        View::share('user', request()->get('user'));
    }

    protected function mergeMainConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../Configs/module-setting.php', 'module-setting'
        );
        $this->mergeConfigFrom(
            __DIR__ . '/../Configs/permission.php', 'permission'
        );
    }

    protected function mapping(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace,
            'middleware' => [
                'backend',
            ],
        ], function ($router) {
            $router->group(['prefix' => admin_prefix()], function () {
                require realpath(__DIR__ . "/../Routes/web.php");
                require realpath(__DIR__ . "/../Routes/api.php");
            });
        });

        $router->group([
            'namespace' => $this->namespace,
            'middleware' => [
                'backend_guest',
            ],
        ], function ($router) {
            $router->group(['prefix' => admin_prefix()], function () {
                require realpath(__DIR__ . "/../Routes/public.php");
            });
        });

        $router->group([
            'namespace' => $this->namespace,
            'prefix' => 'install',
            'middleware' => [
                'web',
            ],
        ], function ($router) {
            require realpath(__DIR__ . "/../Routes/install.php");
        });
    }

    public function registerContainer()
    {
        $this->app->singleton('setting', function ($app) {
            return Setting::get();
        });
        $this->app->singleton('role', function ($app) {
            return (new Role)->allCached();
        });
    }

    protected function loadModules()
    {
        $listModule = config('modules.load');
        if ($listModule) {
            foreach ($listModule as $mod) {
                try {
                    if (class_exists($mod)) {
                        $this->app->register($mod);
                    }
                } catch (Exception $e) {
                    //any error in registering the class will be ignored
                }
            }
        }
    }

    protected function registerAlias()
    {
        //automatically load alias
        $aliasData = [
            'Setting' => \App\Core\Facades\SettingComponentFacade::class,
            'Sidebar' => \App\Core\Facades\SidebarComponentFacade::class,
            'SidebarItem' => \App\Core\Facades\SidebarItemComponentFacade::class,
            'Permission' => \App\Core\Facades\PermissionComponentFacade::class,
            'SEO' => \App\Core\Facades\SeoComponentFacade::class,
            'ColumnListing' => \App\Core\Facades\ColumnListingComponentFacade::class,
            'Themes' => \App\Core\Facades\ThemeFacade::class,
        ];

        foreach ($aliasData as $al => $src) {
            AliasLoader::getInstance()->alias($al, $src);
        }
    }
}
