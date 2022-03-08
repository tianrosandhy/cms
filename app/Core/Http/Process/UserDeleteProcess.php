<?php
namespace App\Core\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use Validator;

class UserDeleteProcess extends BaseProcess implements CanProcess
{

    public function validate()
    {
        $validate = Validator::make($this->request->all(), [
            //your validation rules
        ]);

        if ($validate->fails()) {
            throw new ProcessException($validate);
        }
    }

    public function process()
    {
        if (empty($this->id) && $this->request->list_id && is_array($this->request->list_id)) {
            $this->runBatchDelete($this->request->list_id);
        } else {
            $this->runSingleDelete($this->id);
        }
    }

    protected function runBatchDelete($ids = [])
    {
        foreach ($ids as $id) {
            $this->runSingleDelete($id);
        }
    }

    protected function runSingleDelete($id)
    {
        //in case ada tambahan hapus yg lain2 juga bisa ditambahkan disini
        $pk = $this->model->getKeyName();
        $this->model->where([
            $pk => $id,
        ])->delete();
        return true;
    }

}
