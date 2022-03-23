<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use TianRosandhy\Autocrud\DataStructure\ExportStructure;

class ExportStructureCollection extends BaseStructure
{
    public function __construct()
    {
        $this->struct_type = 'export';
        parent::__construct();
    }

    public function register(ExportStructure $item)
    {
        $this->structure[] = $item;
        return $this;
    }

    public function registers(array $item)
    {
        foreach ($arr as $item) {
            if ($item instanceof ExportStructure) {
                $this->structure[] = $item;
            }
        }
        return $this;
    }    
}