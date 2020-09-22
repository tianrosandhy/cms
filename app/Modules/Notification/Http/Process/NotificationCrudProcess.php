<?php
namespace App\Modules\Notification\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Notification\Http\Skeleton\NotificationSkeleton;

class NotificationCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new NotificationSkeleton;
	}

	public function config(){
		return [
			'error_redirect_target' => null, //ex : url('your-url-when-fail')
			'success_redirect_target' => route('admin.notification.index'), //ex : url('your-url-when-success')
			'success_message' => 'Your data has been saved successfully',
			'error_message' => null
		];
	}

}