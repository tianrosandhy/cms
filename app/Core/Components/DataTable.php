<?php
namespace App\Core\Components;

use App\Core\Base\Structure\BaseStructure;
use App\Core\Components\DataTable\DataTableProcessor;

class DataTable
{
    use DataTableProcessor;

    public $structure;
    public $request;
    public $mode = 'datatable'; //mode : datatable & custom

    public function __construct()
    {
        $this->request = request();
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function setStructure(BaseStructure $structure)
    {
        $this->structure = $structure;
        $this->mode = $this->structure->mode ?? 'datatable';
        return $this;
    }

    public function assets()
    {
        return view('core::components.datatable.asset', [
            'structure' => $this->structure,
        ]);
    }

    public function customAssets()
    {
        return view('core::components.datatable.custom-asset', [
            'structure' => $this->structure,
        ]);
    }

    public function tableView()
    {
        return view('core::components.datatable.table-view', [
            'structure' => $this->structure,
        ]);
    }

    public function customTableView()
    {
        return view('core::components.datatable.custom-table-view', [
            'structure' => $this->structure,
        ]);
    }

}
