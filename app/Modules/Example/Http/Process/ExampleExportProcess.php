<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseExportProcess;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExampleExportProcess extends BaseExportProcess
{
	public function exportModel(){
		return new Example;
	}

	public function exportStructure(){
		return new ExampleStructure;
	}

}