<?php
namespace App\Core\Components\DataTable;

use App\Core\Shared\DynamicProperty;
use Storage;

class DataTableExporter 
{
    use DynamicProperty;

    public 
        $header_map = [],
        $row_data = [],
        $filename = null,
        $separator = ',';

    public function export(){
        $csv = 'sep=' . $this->separator . PHP_EOL;
        foreach($this->header_map as $field => $label){
            $row[] = csvCell($label);
        }
        $csv .= implode($this->separator, $row) . PHP_EOL;

        foreach($this->row_data as $single){
            $row = [];
            foreach($this->header_map as $field => $label){
                $item = $single[$field] ?? "";
                $row[] = csvCell($item);
            }
            $csv .= implode($this->separator, $row) . PHP_EOL;
        }

        // write to storage
        $filename = $this->filename ?? 'Export' . date('YmdHis');
        $savepath = 'export/' . $filename . '.csv';
        Storage::put($savepath, $csv);
        return $savepath;
    }    
}