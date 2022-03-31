<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use Exception;
use DB;

class BaseDeleteProcess extends BaseProcess implements CanProcess
{
    public function config()
    {
        return [
            'error_redirect_target' => null, //ex : url('your-url-when-fail')
            'success_redirect_target' => null, //ex : url('your-url-when-success')
            'success_message' => 'Your data has been deleted successfully',
            'error_message' => null,
        ];
    }

    /*
     * These methods below can be overriden in your custom delete process class
     */
    public function validate()
    {
        $validate = Validator::make($this->request->all(), [
            //your validation rules
        ]);

        if ($validate->fails()) {
            throw new ProcessException($validate);
        }
    }

    public function afterBatchDelete(array $deleted_id = [])
    {
        //
    }

    public function afterSingleDelete($deleted_id = null)
    {
        //
    }

    //--------------

    protected function currentModel()
    {
        $model = $this->model ?? null;
        if (empty($model) && method_exists($this, 'model')) {
            $model = $this->model();
        }
        if (empty($model)) {
            throw new ProcessException("You need to define the model that will be deleted first.");
        }
        return $model;
    }

    public function process()
    {
        DB::beginTransaction();
        try {
            if (empty($this->id) && $this->request->list_id && is_array($this->request->list_id)) {
                $this->runBatchDelete($this->request->list_id);
                $this->afterBatchDelete($this->request->list_id);
            } else {
                $this->runSingleDelete($this->id);
                $this->afterSingleDelete($this->id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function runBatchDelete($ids = [])
    {
        $model = $this->currentModel();
        $pk = $model->getKeyName();
        return $model->whereIn($pk, $ids)->delete();
    }

    protected function runSingleDelete($id)
    {
        $model = $this->currentModel();
        $pk = $model->getKeyName();
        return $model->where([
            $pk => $id,
        ])->delete();
    }

}
