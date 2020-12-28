<?php
namespace App\Modules\Notification\Http\Process;

use App\Core\Http\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use DataTable;
use App\Modules\Notification\Http\Skeleton\NotificationSkeleton;

class NotificationDatatableProcess extends BaseProcess
{
	public function __construct(){
		parent::__construct();
		$this->skeleton = new NotificationSkeleton;
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