<?php
namespace TianRosandhy\Autocrud\DataStructure;

class DatatableStructure extends BaseDataStructure
{
    public function __construct()
    {
        $this->struct_type = 'datatable';
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
    public $order_override = null;

    /**
     * (Closure) if you want to override the search filter behavior of this field. Default : filter by $field
     */
    public $search_override = null;

    /**
     * (string) mark this field as a default order (ASC/DESC)
     */
    public string $default_order = '';
    
}