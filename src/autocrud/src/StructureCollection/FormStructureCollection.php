<?php
namespace TianRosandhy\Autocrud\StructureCollection;

use TianRosandhy\Autocrud\DataStructure\FormStructure;
use TianRosandhy\Autocrud\StructureCollection\Form\Renderer;
use TianRosandhy\Autocrud\StructureCollection\Form\Processor;
use Illuminate\Database\Eloquent\Model;

class FormStructureCollection extends BaseStructureCollection
{
    use Renderer;
    use Processor;

    public Model $data;

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