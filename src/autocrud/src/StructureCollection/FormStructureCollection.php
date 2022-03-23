<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use TianRosandhy\Autocrud\DataStructure\FormStructure;

class FormStructureCollection extends BaseStructure
{
    public function __construct()
    {
        $this->struct_type = 'form';
        parent::__construct();
    }

    public function register(FormStructure $item)
    {
        $this->structure[] = $item;
        return $this;
    }

    public function registers(array $item)
    {
        foreach ($arr as $item) {
            if ($item instanceof FormStructure) {
                $this->structure[] = $item;
            }
        }
        return $this;
    }    
}