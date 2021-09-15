<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Exceptions\ProcessException;
use Validator;
use DataTable;
use App\Modules\Example\Http\Structure\ExampleStructure;

class ExampleDatatableProcess extends BaseProcess
{
	public function __construct(){
		parent::__construct();
		$this->structure = new ExampleStructure;
	}
	
	public function currentDataTable(){
		return DataTable::setStructure($this->structure);
	}

	public function validate(){
		return $this->currentDataTable()->validateRequest();
	}

	public function process(){
		return $this->currentDataTable()->process();
	}

	public function revert(){
		//your logic when validation or process failed to running
	}

}