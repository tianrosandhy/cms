<?php
namespace TianRosandhy\Autocrud\StructureCollection\Datatable;

/**
 * DatatableStructureCollection Renderer logic collections
 */
trait Renderer
{
    public function renderTable()
    {
        $pass = get_object_vars($this);
        $pass['context'] = $this;
        return view(
            config('autocrud.renderer.table'), $pass 
        )->render();
    }
    
    public function renderAsset()
    {
        $pass = get_object_vars($this);
        $pass['context'] = $this;
        return view(
            config('autocrud.renderer.asset'), $pass 
        )->render();
    }
    

    // datatable context ajax method helpers
    public function generateSearchQuery()
    {
        $out = 'data.keywords = new Object; ';
        $i = 0;
        foreach ($this->structure as $row) {
            if ($row->isVisible()) {
                $fld = str_replace('[]', '', $row->getField());
                // $out .= 'data.columns[' . $i . ']["search"]["value"] = $("#searchBox-'.$this->hash.' [data-id=\'datatable-filter-' . $fld . '\']").val(), ';
                $out .= 'data.keywords["'.$fld.'"] = $("#searchBox-'.$this->hash.' [data-id=\'datatable-filter-' . $fld . '\']").val(); ';                
                $i++;
            }
        }
        return $out;
    }

    public function datatableOrderable()
    {
        $out = '';
        $i = 0;
        foreach ($this->structure as $row) {
            if ($row->isVisible()) {
                if (!$row->getOrderable()) {
                    $out .= "{'targets' : " . $i . ", 'orderable' : false}, ";
                }
                $i++;
            }
        }
        $out .= "{'targets' : ".$i.", 'orderable' : false} ";
        return $out;
    }

    public function datatableDefaultOrder()
    {
        $order_data = ''; //fallback
        $i = 0;
        foreach ($this->structure as $row) {
            if ($row->isVisible()) {
                if (strlen($row->getDefaultOrder()) > 0) {
                    //kalau ada salah satu field yang set default order, langsung hentikan loop
                    $order_data = '[' . $i . ', "' . $row->getDefaultOrder() . '"]';
                    break;
                }
                $i++;
            }
        }

        return $order_data;
    }

    public function datatableColumns()
    {
        $i = 0;
        $out = '';
        foreach ($this->structure as $row) {
            if ($row->isVisible()) {
                $fld = str_replace('[]', '', $row->field());
                $out .= "{data : '" . $fld . "'}, ";
            }
        }
        $out .= "{data : 'action'}";
        return $out;
    }        
}