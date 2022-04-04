<?php
namespace App\Console\Commands;

use FilesystemIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class AutocrudBlankSubmodule extends Command
{
    protected $signature = 'autocrud:blanksubmodule {old_module?} {module_name?}';
    protected $description = 'Scaffold CMS Blank Sub Module';

    public $proper_name, $lowercase_name, $namespace, $old_module_name, $module_name, $module_dir;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $old_module = $this->argument('old_module');
        $name = $this->argument('module_name');

        if (empty($old_module)) {
            $old_module = $this->ask('Please insert your existing module name : ');
        }

        $this->old_module_name = ucwords($old_module);
        $this->old_module_name = str_replace(' ', '', $this->old_module_name);
        $this->namespace = 'App\\Modules\\' . $this->old_module_name;
        $this->lowercase_old_name = strtolower($this->old_module_name);
        if (!$this->isOldModuleExists()) {
            return $this->error('Old Module name ' . $this->old_module_name . ' is not exists');
        }

        if (empty($name)) {
            $name = $this->ask('Please insert your new blank submodule name');
        }
        $this->proper_name = ucwords($name);
        $this->module_name = str_replace(' ', '', $this->proper_name);
        $this->lowercase_name = strtolower(str_replace(' ', '_', $this->proper_name));

        $base_dir = base_path('app/Modules/' . $this->old_module_name . '/');
        $path = realpath($base_dir);
        if (!$path) {
            $this->error('Directory ' . $path . ' is not exists. We cannot generate submodule in non existent directory');
        } else {
            $this->module_dir = $path;
            copy_directory(__DIR__ . '/../../Core/Stubs/BlankSubModules', $this->module_dir);
            $this->info('Scaffolding file copied successfully');

            $this->renameAllStubToPhp();

            $this->renameModules([
                'Facades/BlankFacade.php',
                'Http/Controllers/BlankController.php',
                'Http/Process/' . $this->module_name . '/BlankCrudProcess.php',
                'Http/Process/' . $this->module_name . '/BlankDeleteProcess.php',
                'Migrations/2022_02_01_000000_blank.php',
                'Migrations/2022_02_01_000001_blank_translator.php',
                'Models/Blank.php',
                'Models/BlankTranslator.php',
                'Services/BlankInstance.php',
            ]);

            $this->changeContents([
                'Facades/' . $this->module_name . 'Facade.php',
                'Http/Controllers/' . $this->module_name . 'Controller.php',
                'Http/Process/' . $this->module_name . '/' . $this->module_name . 'CrudProcess.php',
                'Http/Process/' . $this->module_name . '/' . $this->module_name . 'DeleteProcess.php',
                'Migrations/2022_02_01_000000_' . $this->lowercase_name . '.php',
                'Migrations/2022_02_01_000001_' . $this->lowercase_name . '_translator.php',
                'Models/' . $this->module_name . '.php',
                'Models/' . $this->module_name . 'Translator.php',
                'Services/' . $this->module_name . 'Instance.php',
                'Views/' . $this->lowercase_name . '/crud.blade.php',
                'Views/' . $this->lowercase_name . '/index.blade.php',
            ]);

            // last step : add new Route appender
            $route_string = PHP_EOL . "generateAdminRoute('/" . $this->lowercase_name . "', '\\" . $this->namespace . "\Http\Controllers\\" . $this->module_name . "Controller', '" . $this->lowercase_name . "');" . PHP_EOL;
            $this->appendContent("Routes/web.php", $route_string);

            $this->info('New submodule scaffold has been created for you. Now you just need to define : SidebarGenerator, Routes, Translations, ');

        }

    }

    protected function isOldModuleExists()
    {
        return file_exists(base_path('app/Modules/' . $this->old_module_name));
    }

    protected function renameAllStubToPhp()
    {
        $path = $this->module_dir;

        // manually rename "Blank" directory to its current module name in Process & Presenter
        rename(
            $path . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Process' . DIRECTORY_SEPARATOR . 'Blank',
            $path . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'Process' . DIRECTORY_SEPARATOR . $this->module_name
        );
        rename(
            $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'blank',
            $path . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $this->lowercase_name,
        );

        $di = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        //rename .stub -> .php
        foreach ($di as $fname => $fio) {
            $file_full_path = $fio->getPath() . DIRECTORY_SEPARATOR . $fio->getFilename();
            if (strpos($file_full_path, '.stub') !== false) {
                rename($file_full_path, str_replace('.stub', '.php', $file_full_path));
            }
        }
    }

    protected function renameModule($module_path)
    {
        $first_char = substr($module_path, 0, 1);
        if (!in_array($first_char, ['/', '\\', DIRECTORY_SEPARATOR])) {
            $module_path = DIRECTORY_SEPARATOR . $module_path;
        }

        $rename_path = str_replace('blank', $this->lowercase_name, $module_path);
        $rename_path = str_replace('Blank', $this->module_name, $rename_path);
        $rename_path = str_replace('.stub', '.php', $rename_path);

        rename($this->module_dir . $module_path, $this->module_dir . $rename_path);
    }

    protected function renameModules($list_of_path = [])
    {
        foreach ($list_of_path as $path) {
            $this->renameModule($path);
        }
    }

    protected function changeContents($list_of_path)
    {
        foreach ($list_of_path as $path) {
            $this->changeContent($path);
        }
    }

    protected function appendContent($path, $string)
    {
        $first_char = substr($path, 0, 1);
        if (!in_array($first_char, ['/', '\\', DIRECTORY_SEPARATOR])) {
            $path = DIRECTORY_SEPARATOR . $path;
        }
        $content = file_get_contents($this->module_dir . $path);
        $content .= $string;
        file_put_contents($this->module_dir . $path, $content);
    }

    protected function changeContent($path)
    {
        $first_char = substr($path, 0, 1);
        if (!in_array($first_char, ['/', '\\', DIRECTORY_SEPARATOR])) {
            $path = DIRECTORY_SEPARATOR . $path;
        }

        $content = file_get_contents($this->module_dir . $path);
        $content = str_replace('[MODULE_NAME]', $this->module_name, $content);
        $content = str_replace('[LOWERCASE_OLD_NAME]', $this->lowercase_old_name, $content);
        $content = str_replace('[LOWERCASE_MODULE_NAME]', $this->lowercase_name, $content);
        $content = str_replace('[PROPER_MODULE_NAME]', $this->proper_name, $content);
        $content = str_replace('[NAMESPACE]', $this->namespace, $content);
        file_put_contents($this->module_dir . $path, $content);
    }

}
