<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Http\Process\BaseCrudProcess;
use App\Modules\Example\Http\Skeleton\ExampleSkeleton;

class ExampleCrudProcess extends BaseCrudProcess
{
	public function setSkeleton(){
		return new ExampleSkeleton;
	}

}