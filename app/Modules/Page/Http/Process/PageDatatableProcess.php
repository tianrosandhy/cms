<?php
namespace App\Modules\Page\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use DataTable;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageDatatableProcess extends BaseProcess
{
	public function __construct(){
		parent::__construct();
		$this->skeleton = new PageSkeleton;
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