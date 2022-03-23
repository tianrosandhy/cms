<?php
namespace TianRosandhy\Autocrud\DataStructure;

class ExportStructure extends BaseDataStructure
{
    public function __construct()
    {
        $this->struct_type = 'export';
    }

    /**
     * (bool) set current field can be ordered (default = true)
     */
    public $orderable = false;

    /**
     * (bool) set current field can be filtered (default = true)
     */
    public $searchable = false;

    /**
     * (string|Closure) if you want to override the default order field name. Default : order by $field
     */
    public $order_override;

    /**
     * (Closure) if you want to override the search filter behavior of this field. Default : filter by $field
     */
    public $search_override;
    
}