<?php
namespace App\Core\Http\Skeleton;

use App\Core\Components\DataTable\DataStructure;
use Validator;

class BaseSkeleton
{
	use SkeletonHelper;

	public $structure = [];

	public function __construct(){
		$this->request = request();
		if(method_exists($this, 'handle')){
			$this->handle();
		}
	}

	public function generateValidation($mode='create'){
		$rule = [];
		$trans = [];
		$mode = strtolower($mode);
		foreach($this->output() as $row){
			if($row->getCreateValidation() && in_array($mode, ['store', 'insert', 'create'])){
				$rule[$row->getField()] = $row->getCreateValidation();
				$trans = array_merge($trans, $row->getValidationTranslation());
			}
			if($row->getUpdateValidation() && in_array($mode, ['update', 'edit'])){
				$rule[$row->getField()] = $row->getUpdateValidation();
				$trans = array_merge($trans, $row->getValidationTranslation());
			}
		}

		if($rule){
			return Validator::make(request()->all(), $rule, $trans);
		}
	}

	public function name(){
		$class_name = get_class($this);
		$split = explode('\\', $class_name);
		return $split[count($split)-1];
	}

	public function register(DataStructure $item){
		$this->structure[] = $item;
		return $this;
	}

	public function registers($arr=[]){
		foreach($arr as $item){
			if($item instanceof DataStructure){
				$this->structure[] = $item;
			}
		}
		return $this;
	}

	public function output(){
		return collect($this->structure);
	}



	// FOR DATATABLE HELPER METHODs
	public function route(){
		if(method_exists($this, 'dataTableRoute')){
			return $this->dataTableRoute();
		}
	}

	public function generateSearchQuery(){
		$out = '';
		$i = 0;
		foreach($this->output() as $row){
			if(!$row->getHideTable()){
				$fld = str_replace('[]', '', $row->getField());
				$out .= 'data.columns['.$i.']["search"]["value"] = $("#datatable-filter-'.$fld.'").val(), ';
				$i++;
			}
		}
		return $out;
	}


	public function datatableOrderable(){
		$out = '';
		$i = 0;
		foreach($this->output() as $row){
			if($row->getHideTable() == false){
				if(!$row->getOrderable()){
					$out .= "{'targets' : ".$i.", 'orderable' : false}, ";
				}
				$i++;
			}
		}
		return $out;
	}

	public function datatableColumns(){
		$i = 0;
		$out = '';
		foreach($this->output() as $row){
			if($row->getHideTable() == false){
				$fld = str_replace('[]', '', $row->field);
				$out .= "{data : '".$fld."'}, ";
			}
		}
		$out .= "{data : 'action'}";
		return $out;
	}


}