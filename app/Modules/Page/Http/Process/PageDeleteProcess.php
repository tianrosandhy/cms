<?php
namespace App\Modules\Page\Http\Process;

use App\Core\Http\Process\BaseDeleteProcess;
use App\Core\Exceptions\ProcessException;
use App\Modules\Page\Http\Skeleton\PageSkeleton;
use Validator;

class PageDeleteProcess extends BaseDeleteProcess
{
	public function validate(){
		$validate = Validator::make($this->request->all(), [
			//your validation rules
		]);

		if($validate->fails()){
			throw new ProcessException($validate);
		}
	}

	public function process(){
		if(empty($this->id) && $this->request->list_id && is_array($this->request->list_id)){
			$this->runBatchDelete($this->request->list_id);
		}
		else{
			$this->runSingleDelete($this->id);
		}
	}

	protected function runBatchDelete($ids=[]){
		foreach($ids as $id){
			$this->runSingleDelete($id);
		}
	}

	protected function runSingleDelete($id){
		//in case ada tambahan hapus yg lain2 juga bisa ditambahkan disini
		$pk = $this->model->getKeyName();
		$this->model->where([
			$pk => $id
		])->delete();
		return true;
	}



	public function revert(){
		//your logic when validation or process failed to running
	}


}