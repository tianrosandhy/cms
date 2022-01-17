<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AutocrudStructure extends Command
{

    protected $signature = 'autocrud:structure';
    protected $description = 'Create structure autocrud in module';

    public 
        $module_name,
        $structure_name;

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //
        do{
            $this->module_name = $this->ask('Where do you want to create the Structure class?');
        }while(strlen($this->module_name) == 0);

        $this->module_name = ucfirst($this->module_name);
        if(strtolower($this->module_name) == 'core'){
            $this->mpath = 'Core';
        }
        else{
            $this->mpath = 'Modules/'.$this->module_name;
        }
        $namespace = 'App/' . $this->mpath.'/Http/Structure';

        $try_location = base_path('app/'.$this->mpath);
        if(is_dir($try_location)){
            do{
                $this->structure_name = $this->ask('Type your Structure classname');
            }while(strlen($this->structure_name) == 0);

            $this->proper_name = ucwords($this->structure_name);
            $this->structure_name = ucfirst(str_replace(' ', '', $this->structure_name));
            $this->lowercase_name = strtolower(str_replace(' ', '_', $this->proper_name));
            
            $this->createStructureCopy();
            return $this->info('Structure class has been made in "'.$namespace.'/'.$this->structure_name.'"');
        }
        else{
            return $this->error('Module name "'.$this->module_name.'" is not exists.');
        }
    }

    public function createStructureCopy(){
        $savepath = base_path('app/'.$this->mpath.'/Http/Structure/'.$this->structure_name.'.php');
        if(is_file($savepath)){
            $this->error('File ' . $savepath .' is already exists.');
            die();
        }

        $namespace = 'App\\' . str_replace('/', '\\', $this->mpath);
        $stub_path = base_path(config('module-setting.stubs.structure'));
        $stub_file = fopen($stub_path, 'r');
        $stub_content = fread($stub_file, filesize($stub_path));
        $stub_content = str_replace('[CURRENT_NAMESPACE]', $namespace, $stub_content);
        $stub_content = str_replace('[MODULE_NAME]', $this->structure_name, $stub_content);
        $stub_content = str_replace('[LOWERCASE_MODULE_NAME]', $this->lowercase_name, $stub_content);
        $stub_content = str_replace('[NAMESPACE]', $namespace, $stub_content);

        fclose($stub_file);

        file_put_contents($savepath, $stub_content);
    }
}
