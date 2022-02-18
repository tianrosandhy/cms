<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseDatatableProcess;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExampleDatatableProcess extends BaseDatatableProcess
{
	public function structure(){
		return new ExampleStructure;
	}
}