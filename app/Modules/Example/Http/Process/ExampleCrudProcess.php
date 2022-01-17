<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseCrudProcess;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExampleCrudProcess extends BaseCrudProcess
{
	public function setStructure(){
		return new ExampleStructure;
	}

}