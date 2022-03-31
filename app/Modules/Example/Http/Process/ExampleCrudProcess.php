<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Example\Http\Structure\ExampleFormStructure;

class ExampleCrudProcess extends BaseProcess
{
    public function __construct($instance = null)
    {
        parent::__construct();
        if (isset($instance->id)) {
            $this->mode = 'update';
        } else {
            $this->mode = 'create';
        }
        $this->instance = $instance;
        $this->structure = new ExampleFormStructure($this->instance);
    }

    public function validate()
    {
        // 
    }

    public function process()
    {
        $response = $this->structure->autoCrud();
        if (!$response->ok()) {
            throw new ProcessException($response->errorFirst());
        }
    }
}