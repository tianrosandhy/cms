<?php
namespace App\Core\Components;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Exception;
use Closure;
use Log;

class DatabaseStructureModifier
{
	public 
        $command_run_count,
        $info,
        $connection;

    public function __construct(){
        $this->info = [];
        $this->connection = 'mysql';
    }

    public function setConnection($connection_name){
        if(config('database.connections.' . $connection_name)){
            $this->connection = $connection_name;
        }
        else{
            Log::warning("Connection string $connection_name is not exists in current autocrud migration modifier file.");
        }
    }

    // method called for update/add/drop schema fields
    public function handleTable($tb_name, Closure $table_function){
        try {
            Schema::connection($this->connection)->table($tb_name, $table_function);
            $this->addInfo($tb_name.' field has been updated');
            $this->command_run_count++;
        } catch (Exception $e) {}
    }

    protected function addInfo($string_msg){
        $this->info[] = $string_msg;
    }

    public function getCommandRunCount(){
    	return $this->command_run_count;
    }

    public function getInfo(){
        return $this->info;
    }

}