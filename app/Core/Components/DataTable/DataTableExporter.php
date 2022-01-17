<?php
namespace App\Core\Components\DataTable;

use App\Core\Shared\DynamicProperty;
use App\Core\Excels\ArrayExporter;
use Storage;
use Excel;

class DataTableExporter 
{
    use DynamicProperty;

    public 
        $header_map = [],
        $row_data = [],
        $filename = null,
        $separator = ',';

    public function export(){
        $exportType = $this->exportType ?? 'xlsx';

        $filename = $this->filename ?? 'Export' . date('YmdHis');
        $savepath = 'export/' . $filename . '.' . $exportType;

        if($exportType == 'csv'){
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
            Storage::put($savepath, $csv);
        }
        else{
            // default : use maatwebsite 
            Excel::store(new ArrayExporter($this->header_map, $this->row_data), $savepath);
        }
        return $savepath;

    }    
}