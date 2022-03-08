<?php
namespace App\Core\Base\Process;

use App\Core\Base\Process\BaseProcess;
use App\Core\Contracts\CanProcess;
use App\Core\Exceptions\ProcessException;
use DataTable;

class BaseDatatableProcess extends BaseProcess implements CanProcess
{
    public function __construct()
    {
        parent::__construct();
    }

    public function currentDataTable()
    {
        $structure = $this->structure ?? null;
        if (empty($structure) && method_exists($this, 'structure')) {
            $structure = $this->structure();
        }
        if (empty($structure)) {
            throw new ProcessException("You need to define the structure parameter for the DatatableProcess class");
        }
        return DataTable::setStructure($structure);
    }

    public function validate()
    {
        return $this->currentDataTable()->validateRequest();
    }

    public function process()
    {
        return $this->currentDataTable()->process();
    }

    public function revert()
    {
        //your logic when validation or process failed to running
    }

}
