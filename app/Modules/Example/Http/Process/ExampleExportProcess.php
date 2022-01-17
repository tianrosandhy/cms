<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseExportProcess;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Http\Structure\ExampleStructure;
use App\Core\Contracts\CanProcessExport;

class ExampleExportProcess extends BaseExportProcess implements CanProcessExport
{
	public function exportName() : string{
		return 'Example Export';
	}

	public function exportModel(){
		return new Example;
	}

	public function exportStructure(){
		return new ExampleStructure;
	}

}