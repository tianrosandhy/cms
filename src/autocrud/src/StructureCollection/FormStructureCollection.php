<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use TianRosandhy\Autocrud\DataStructure\FormStructure;
use TianRosandhy\Autocrud\StructureCollection\Form\Renderer;

class FormStructureCollection extends BaseStructureCollection
{
    use Renderer;

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

    public function registers(array $arr)
    {
        foreach ($arr as $item) {
            if ($item instanceof FormStructure) {
                $this->structure[] = $item;
            }
        }
        return $this;
    }    
}