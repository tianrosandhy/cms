<?php
namespace App\Modules\Navigation\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Navigation\Http\Skeleton\NavigationSkeleton;

class NavigationCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new NavigationSkeleton;
	}

}