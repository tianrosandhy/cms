<?php
namespace TianRosandhy\Autocrud\Generator\Export;

use TianRosandhy\Autocrud\Generator\BaseGenerator;
use TianRosandhy\Autocrud\DataStructure\ExportStructure;

class ExportCollection extends BaseGenerator
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