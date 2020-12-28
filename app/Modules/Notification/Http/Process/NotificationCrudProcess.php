<?php
namespace App\Modules\Notification\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Notification\Http\Skeleton\NotificationSkeleton;

class NotificationCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new NotificationSkeleton;
	}

}