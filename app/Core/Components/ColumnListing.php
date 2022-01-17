<?php
namespace App\Core\Components;

use Schema;
use Illuminate\Database\Eloquent\Builder;

class ColumnListing
{
    public function model($model_instance){
        if($model_instance instanceof Builder){
            $model_instance = $model_instance->getModel();
        }
        $table_name = $model_instance->getTable();

        // update : fix model to another database schema
        $conn_name = $model_instance->getConnectionName();
        return Schema::connection($conn_name)->getColumnListing($table_name);
    }
}