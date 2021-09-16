<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseImportProcess;
use App\Modules\Example\Models\Example;
use App\Modules\Example\Http\Structure\ExampleStructure;
use App\Core\Contracts\CanProcessImport;

class ExampleImportProcess extends BaseImportProcess implements CanProcessImport
{
    public function __construct($importID){
        $this->importID = $importID;
    }

    public function handleImport($rows=[]){
        // write all import logic here
        $result = Example::insertOrIgnore($rows);
        if($result > 0){
            $this->setSuccessMessage("Import success. Added ".$result." new data imported");
        }
        else{
            $this->setSuccessMessage("Import success. No new data to be imported");
        }
        return $result;
    }
}