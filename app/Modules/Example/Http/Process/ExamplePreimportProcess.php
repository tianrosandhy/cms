<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BasePreimportProcess;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Http\Structure\ExampleStructure;
use App\Core\Contracts\CanProcessPreimport;

class ExamplePreimportProcess extends BasePreimportProcess implements CanProcessPreimport
{
    public function importName() : string{
        return 'ExampleImportData';
    }

	public function importStructure(){
		return new ExampleStructure;
	}

	public function rowValidator($rows=[]){
		// $this->addError('add new fatal error in export');
		// $this->addWarning('add new warning in export');
		$i = 0;
		foreach($rows as $row){
			$i++;
			if(!isset($row['text']) || !isset($row['number'])){
				$this->addError("Column text and number is required to be filled.");
			}
			
			$radio = $row['radio'] ?? null;
			if(empty($radio)){
				$this->addWarning("Column radio in row ".$i." is empty");
			}
		}
	}
}