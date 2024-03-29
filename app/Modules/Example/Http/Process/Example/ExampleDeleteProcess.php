<?php
namespace App\Modules\Example\Http\Process\Example;

use App\Core\Base\Process\BaseDeleteProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Example\Models\Example;
use Validator;

class ExampleDeleteProcess extends BaseDeleteProcess
{
    public function __construct($id=null)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
    * The model target that will be deleted
    */
    public function model()
    {
        return new Example;
    }

    /**
    * This method will be called after the batch data deleted successfully
    * @param array $deleted_ids : The lists of deleted id in defined model
    */
    public function afterBatchDelete(array $deleted_ids=[])
    {
        // your logic when batch deleted is triggered
    }

    /**
    * This method will be called after the single data deleted successfully
    * @param $deleted_id : The single ID of deleted data in defined model
    */
    public function afterSingleDelete($deleted_id=null)
    {
        // 
    }

}