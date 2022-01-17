<?php
namespace App\Core\Base\Transformer;

use App\Core\Shared\DynamicProperty;
use App\Core\Base\Structure\StructureHelper;

class BaseTransformer
{
    use DynamicProperty, StructureHelper;

    public $model;

    public function __construct($model=null){
        $this->model = $model;
        $this->request = request();
    }

    public function reform($collection=[], $mode='datatable'){
        $out = [];
        foreach($collection as $row){
            $out[] = $this->transform($row, $mode);
        }
        return $out;
    }
}