<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use Storage;

class BaseImportProcess extends BaseProcess implements CanProcess
{
    public function validate(){
        if(!$this->importID){
            throw new ProcessException("Import ID is not set yet");
        }

        try{
            $path = decrypt($this->importID);
        }catch(\Exception $e){
            throw new ProcessException("Cannot verify the process. Please try upload again");
        }

        if(!Storage::exists($path)){
            throw new ProcessException("File uploaded not found. Please try upload again");
        }

        $string = Storage::get($path);
        $this->storedData = json_decode($string, true);
    }

    public function process(){
        foreach($this->storedData as $idx => $row){
            if(empty($row)){
                unset($this->storedData[$idx]);
            }
        }
        if(empty($this->storedData)){
            throw new ProcessException("No data to be imported");
        }
        $this->handleImport($this->storedData);
    }
}