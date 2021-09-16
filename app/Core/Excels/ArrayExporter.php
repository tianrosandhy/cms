<?php
namespace App\Core\Excels;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ArrayExporter extends DefaultValueBinder implements FromView, WithCustomValueBinder
{
    public function __construct($fieldTranslate=[], $data=[]){
        $this->fieldTranslate = $fieldTranslate;
        $this->data = $data;
        $this->view = view('core::excel.export-array', compact('fieldTranslate', 'data'));
    }
    public function view(): View
    {
        return $this->view;
    }

    // all numeric cell will be transformed to string 
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

}