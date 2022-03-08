<?php
namespace App\Modules\Example\Http\Process;

use App\Core\Base\Process\BaseImportProcess;
use App\Core\Contracts\CanProcessImport;
use App\Modules\Example\Models\Example;

class ExampleImportProcess extends BaseImportProcess implements CanProcessImport
{
    public function __construct($importID)
    {
        $this->importID = $importID;
    }

    public function handleImport($rows = [])
    {
        $result = Example::insertOrIgnore($rows);
        if ($result > 0) {
            $this->setSuccessMessage("Import success. Added " . $result . " new data imported");
        } else {
            $this->setSuccessMessage("Import success. No new data to be imported");
        }
        return $result;
    }
}
