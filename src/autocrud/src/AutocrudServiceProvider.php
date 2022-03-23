<?php
namespace TianRosandhy\Autocrud;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class AutocrudServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        // publish the config
        $this->publishes([
            __DIR__ . '/../config/autocrud.php' => config_path('autocrud.php')
        ]);

        // boot blade component
        Blade::componentNamespace('TianRosandhy\Autocrud\InputGenerator\Components', 'autocrud-input');
    }

    public function register()
    {
        // handle package default config
        $this->mergeConfigFrom(
            __DIR__.'/../config/autocrud.php', 'autocrud'
        );

        // handle package default views
        $this->loadViewsFrom(__DIR__ . "/Resources/Views", 'autocrud');

        // handle facade to service alias
        $aliases = [
            'Autocrud' => \TianRosandhy\Autocrud\Autocrud::class,
            'Input' => \TianRosandhy\Autocrud\InputGenerator\Input::class,
            'Language' => \TianRosandhy\Autocrud\Facades\Language::class,
            'DatatableStructure' => \TianRosandhy\Autocrud\Facades\DatatableStructure::class,
            'ExportStructure' => \TianRosandhy\Autocrud\Facades\ExportStructure::class,
            'FormStructure' => \TianRosandhy\Autocrud\Facades\FormStructure::class,
        ];
        foreach ($aliases as $key => $class) {
            AliasLoader::getInstance()->alias($key, $class);
        }
    }

}