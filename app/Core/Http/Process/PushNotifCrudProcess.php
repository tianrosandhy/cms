<?php
namespace App\Core\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Core\Http\Skeleton\PushNotifSkeleton;

class PushNotifCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PushNotifSkeleton;
	}

}