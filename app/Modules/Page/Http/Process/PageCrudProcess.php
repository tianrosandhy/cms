<?php
namespace App\Modules\Page\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Page\Http\Skeleton\PageSkeleton;

class PageCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PageSkeleton;
	}

}