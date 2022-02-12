<?php
namespace App\Core\Base\Structure;

use App\Core\Exceptions\StructureException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Language;

trait StructureHelper
{
	public function getStructureName(){
		$class_name = (string)get_class($this);
		$split = explode("\\", $class_name);
		return $split[count($split)-1];
	}

	//utk generate checker datatable
	public function checkerFormat($row, $primary_key='id'){
		return '<input type="checkbox" data-id="'.$row->{$primary_key}.'" name="multi_check['.$row->{$primary_key}.']" class="multichecker_datatable"><span style="color:transparent; position:absolute;">'.$row->{$primary_key}.'</span>';		
	}

	public function switcherFormat($row, $field='is_active', $mode='toggle'){
		if($mode == 'toggle'){
			$table = $row->getTable();
			return view('core::components.input.yesno', [
				'value' => $row->{$field},
				'name' => $field,
				'attr' => [
					'data-id' => encrypt($row->getKey()),
					'data-pk' => encrypt($row->getKeyName()),
					'data-conn' => encrypt($row->getConnectionName()),
					'table' => encrypt($table),
					'field' => encrypt($field),
					'data-table-switch' => 1
				]
			])->render();
		}
		else{
			return $row->{$field} ? '<span class="p-1 btn btn-success" title="Active"><span class="iconify" data-icon="uim:check"></span>' : '<span class="p-1 btn btn-danger" title="Not Active"><span class="iconify" data-icon="uim:multiply"></span></span>';
		}
	}

	public function getSearchField($field_name){
		$columns = $this->request->columns ?? [];
		foreach($columns as $item){
			$field = $item['data'] ?? null;
			$value = $item['search']['value'] ?? null;
			if(strtolower($field) == strtolower($field_name)){
				return $value;
			}
		}
		return null;
	}









	public function modelTableListing(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
		}
		throw new StructureException('You need to define the model structure first');
	}

	public function getTableName(){
		$model = $this->model();
		if($model instanceof Model || $model instanceof Builder){
			if($model instanceof Builder){
				$model = $model->getModel();
			}
			return $model->getTable();
		}
		throw new StructureException('You need to define the model structure first');
	}

	// generate auto CRUD prepared data by structure's data
	public function autoCrud($lang=null){
		$table_listing = $this->modelTableListing();
		$table_name = $this->getTableName();

		if(empty($lang)){
			$lang = Language::default();
		}

		$post = [];
		foreach($this->output() as $row){
			if(!$row->getHideForm()){
				$field_name = $row->getField();
				if(strpos($field_name, '[]') !== false){
					$field_name = str_replace('[]', '', $field_name);
				}

				if(in_array($field_name, $table_listing)){
					$value_for_saved = $this->request->{$field_name} ?? null;
					if($this->multi_language){
						$fallback = $value_for_saved[Language::default()] ?? null;
						$value_for_saved = $value_for_saved[$lang] ?? $fallback;
					}
					if($row->input_type == 'currency'){
						$value_for_saved = str_replace('.', '', $value_for_saved);
						$value_for_saved = str_replace(',', '.', $value_for_saved);	
					}

					if($row->input_type == 'map'){
						$value_for_saved = !empty($value_for_saved) ? json_encode($value_for_saved) : null;
					}
					if($row->input_type == 'image_multiple' && is_array($value_for_saved)){
						$value_for_saved = implode('|', $value_for_saved);
					}

					// additional check for image_simple type : if there is _old data and empty input, then dont remove the initial data
					if($row->input_type == 'image_simple'){
						$old_image = $this->request->{'_old'.$field_name}['_old'] ?? ($this->request->{'_old'.$field_name}[def_lang()]['_old'] ?? null);
						if(strlen($old_image) > 0 && empty($value_for_saved)){
							try{
								// if old_value cannot be decrypt, then this input will be ignored
								$value_for_saved = decrypt($old_image);
							}catch(\Exception $e){
								$value_for_saved = null;
							}
						}
					}

					//we cannot save the array value to database. by default, parse the value as json value
					if(is_array($value_for_saved)){
						$value_for_saved = json_encode($value_for_saved);
					}
					//set fallback non existent string as null
					if(strlen($value_for_saved) == 0){
						$value_for_saved = null;
					}
					$post[$field_name] = $value_for_saved;
				}
			}
		}
		return $post;
	}

	public function autoCrudMultiLanguage(){
		$out = [];
		foreach(Language::available() as $lang => $langname){
			$out[$lang] = $this->autoCrud($lang);
		}
		return $out;
	}

}