<?php
namespace App\Modules\Post\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Post\Http\Skeleton\PostCategorySkeleton;

class PostCategoryCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new PostCategorySkeleton;
	}

}