<?php
namespace App\Modules\Navigation\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use App\Core\Providers\BaseServiceProvider;

class NavigationServiceProvider extends BaseServiceProvider{
	protected $namespace = 'App\Modules\Navigation\Http\Controllers';

	public function boot(){
		$this->loadMigrationsFrom(realpath(__DIR__."/../Migrations"));
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'navigation');
	}

	public function register(){
		$this->loadHelpers(__DIR__.'/..');
		$this->mapping($this->app->router);
		$this->loadViewsFrom(realpath(__DIR__."/../Views"), 'navigation');
		$this->mergeMainConfig();
		$this->registerAlias();
	}

	protected function mergeMainConfig(){
		$this->mergeConfigFrom(
		    __DIR__.'/../Configs/module-setting.php', 'module-setting'
		);
		$this->mergeConfigFrom(
		    __DIR__.'/../Configs/permission.php', 'permission'
		);
	}

	protected function mapping(Router $router){
		$router->group([
			'namespace' => $this->namespace, 
			'middleware' => [
				'backend', 
			]
		], function($router){
			$router->group(['prefix' => admin_prefix()], function(){
				require realpath(__DIR__."/../Routes/web.php");
				require realpath(__DIR__."/../Routes/api.php");
			});
		});
	}

	protected function registerAlias(){
		//automatically load alias
		$aliasData = [
		    'NavigationInstance' => \App\Modules\Navigation\Facades\NavigationFacade::class,
		];

		foreach($aliasData as $al => $src){
			AliasLoader::getInstance()->alias($al, $src);
		}
	}
}