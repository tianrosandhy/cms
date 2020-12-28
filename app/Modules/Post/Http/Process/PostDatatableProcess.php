<?php
namespace App\Modules\Post\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use DataTable;
use App\Modules\Post\Http\Skeleton\PostSkeleton;

class PostDatatableProcess extends BaseProcess
{
	public function __construct(){
		parent::__construct();
		$this->skeleton = new PostSkeleton;
	}

	public function currentDataTable(){
		return DataTable::setSkeleton($this->skeleton);
	}

	public function validate(){
		return $this->currentDataTable()->validateRequest();
	}

	public function process(){
		return $this->currentDataTable()->process();
	}

	public function revert(){
		//your logic when validation or process failed to running
	}

}