<?php
namespace App\Core\Components;

use Schema;

class ColumnListing
{
    public function model($model_instance){
        $table_name = $model_instance->getTable();
        return Schema::getColumnListing($table_name);
    }
}