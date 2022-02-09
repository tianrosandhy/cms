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

        // check $fillable property first
        $fillable = [];
        if(method_exists($model_instance, 'getFillable')){
            $fillable = $model_instance->getFillable();
        }

        // now we will return a model $fillable lists if defined. 
        if(!empty($fillable)){
            return $fillable;
        }
        
        // if the fillable in model not exists, the fallback is we still call database to get the more valid column listing 
        $table_name = $model_instance->getTable();
        $conn_name = $model_instance->getConnectionName();
        return Schema::connection($conn_name)->getColumnListing($table_name);
    }
}