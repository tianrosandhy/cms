<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseCrudProcess;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExampleCrudProcess extends BaseCrudProcess
{
    public function setStructure()
    {
        return new ExampleStructure;
    }

    /**
    * This method will be called after the default Create / Update process running successfully.
    * You can add additional logic after the basic data stored/updated.
    * @param any $instance : the model of the inserted/updated data 
    */
    public function afterCrud($instance=null)
    {
        
    }
}