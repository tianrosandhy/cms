<?php
namespace App\Core\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use App\Core\Http\Structure\UserFormStructure;
use Validator;

class UserCrudProcess extends BaseProcess implements CanProcess
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
        $this->structure = new UserFormStructure($this->instance);
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

        if ($this->request->password && $this->request->password_confirmation) {
            $value = bcrypt($this->request->value);
            $this->instance->password = $value;
            $this->instance->save();
        }
    }

}
