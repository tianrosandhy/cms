<?php
namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Validator;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Database\Schema\Builder;

class CoreServiceProvider extends BaseServiceProvider{
	protected $namespace = 'App\Core\Http\Controllers';

	public function boot(){
		Builder::defaultStringLength(191);
		$this->loadMigrationsFrom(realpath(__DIR__."/../Migrations"));
		$this->loadTranslationsFrom(__DIR__ . '/../Translations', 'core');
	}

	public function register(){
		$this->loadHelpers(__DIR__.'/..');
		$this->mapping($this->app->router);
		$this->loadViewsFrom(realpath(__DIR__."/../Views"), 'core');
		$this->loadModules();
		$this->mergeMainConfig();
		$this->registerAlias();
		$this->registerContainer();
	}

	protected function mergeMainConfig(){
		// $this->mergeConfigFrom(
		//     __DIR__.'/Config/permission.php', 'permission'
		// );
	}


	protected function mapping(Router $router){
		$router->group([
			'namespace' => $this->namespace, 
			'middleware' => [
				'web', 
			]
		], function($router){
			$router->group(['prefix' => admin_prefix()], function(){
				require realpath(__DIR__."/../Routes/web.php");
				require realpath(__DIR__."/../Routes/api.php");
			});
		});

		$router->group([
			'namespace' => $this->namespace, 
			'prefix' => 'install',
			'middleware' => [
				'web'
			]
		], function($router){
			require realpath(__DIR__."/../Routes/install.php");
		});
	}

	public function registerContainer(){
		// $this->app->singleton('setting', function($app){
		// 	return SettingStructure::get();
		// });
		// $this->app->singleton('role', function($app){
		// 	return Role::with('owner', 'children')->get();
		// });
	}


	protected function loadModules(){
	    $listModule = config('modules.load');
	    if($listModule){
		    foreach($listModule as $mod){
		    	try{
			    	if(class_exists($mod)){
					    $this->app->register($mod);
			    	}
		    	}catch(\Exception $e){
		    		//any error in registering the class will be ignored
		    	}
		    }
	    }
	}	

	protected function registerAlias(){
		// $this->app->bind('image-facade', function ($app) {
		//     return new Services\ImageServices($app);
		// });

		// //automatically load alias
		// $aliasData = [
		//     'ImageService' => \Core\Main\Facades\ImageFacades::class,
		// ];

		// foreach($aliasData as $al => $src){
		// 	AliasLoader::getInstance()->alias($al, $src);
		// }
	}
}