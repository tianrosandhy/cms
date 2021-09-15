<?php
namespace App\Core\Components\DataTable;

use Input;
use Closure;
use App\Core\Shared\DynamicProperty;
use Language;

class DataStructure
{
	use DynamicProperty;

	public 
		// basic
		$field,
		$name,
		$default_order,

		// datatable
		$orderable,
		$searchable,
		$hide_table,
		$hide_form,

		// exporter
		$exportable,
		$export_searchable,
		$hide_export,

		$show_on_create,
		$show_on_update,
		$crud_show_condition,
		$table_show_condition,

		// form & input
		$form_column,
		$input_type,
		$input_attribute,
		$input_array,

		// validation
		$create_validation,
		$update_validation,
		$validation_translation,

		$slug_target,
		$data_source,
		$value_source,
		$value_data,
		$translate,
		$view_source,
		$tab_group,
		$view,
		$fallback;

	public function __construct(){
		//manage default value
		$this->orderable = true;
		$this->searchable = true;
		$this->exportable = true;
		$this->export_searchable = true;
		$this->hide_form = false;
		$this->hide_table = false;
		$this->show_on_create = true;
		$this->show_on_update = true;
		$this->crud_show_condition = null;
		$this->table_show_condition = null;
		$this->hide_export = false;
		$this->form_column = 12;
		$this->data_source = 'text';
		$this->input_type = 'text';
		$this->input_array = false;
		$this->slug_target = false;
		$this->value_source = false;
		$this->translate = true;
		$this->tab_group = 'General';
		$this->validation_translation = [];
		$this->view = null;
		$this->fallback = null;
	}



	public function createInput($data=null, $multi_language=false){
		$config = [
			'type' => $this->input_type,
			'name' => $this->field,
			'attr' => $this->input_attribute,
			'data' => $data,
			'value' => $this->generateStoredValue($data, $multi_language)
		];

		if($this->input_type == 'slug'){
			$config['slug_target'] = $this->slug_target;
		}
		if(in_array($this->input_type, ['select', 'select_multiple', 'radio', 'checkbox'])){
			$config['source'] = $this->data_source;
		}
		if($this->view_source){
			$config['view_source'] = $this->view_source;
		}

		if($multi_language){
			return Input::multiLanguage()->type($this->input_type, $this->field, $config);
		}
		else{
			return Input::type($this->input_type, $this->field, $config);
		}
	}

	protected function generateStoredValue($data, $multi_language=false){
		$field_name = $this->field;
		if(strpos($field_name, '[]') !== false){
			$field_name = str_replace('[]', '', $field_name);
		}

		if($this->value_source){
			$grab_ = \DB::table($this->value_source[0])->find($this->value_source[1]);
			if($multi_language){
				$value[config('cms.language', 'en')] = $grab_->{$this->value_source[2]};
			}
			else{
				$value = $grab_->{$this->value_source[2]};
			}
		}
		elseif($this->value_data){
			if($multi_language){
				foreach([config('cms.language', 'en') => config('cms.language', 'en')] as $lang => $langname){
					$value[$lang] = call_user_func($this->value_data, $data, $lang);
				}
			}
			else{
				$value = call_user_func($this->value_data, $data);
			}
		}
		else{
			if($multi_language){
				foreach([config('cms.language', 'en') => config('cms.language', 'en')] as $lang => $langname){
					$value[$lang] = isset($data->{$field_name}) ? $data->outputTranslate($field_name, $lang, true) : null;
				}
			}
			else{
				$value = isset($data->{$field_name}) ? $data->{$field_name} : null;
			}
		}

		//grab from fallback if empty value
		if(empty($value)){
			if(is_string($value) && strlen($value) > 0){
				// anjir lah.. "0" dibaca empty sama php dong -_-
				return $value;
			}
			$value = $this->fallback;
		}

		return $value;
	}


	public function field($field=''){
		$this->field = $field;
		$this->inputAttribute();
		return $this;
	}

	//quick structure
	public function checker($name='id'){
		$this->field($name);
		$this->orderable(false);
		$this->searchable(false);
		$this->exportable(false);
		$this->hideExport(true);
		$this->name('<input type="checkbox" name="checker_all" id="checker_all_datatable">');
		$this->hideForm();
		return $this;
	}

	public function switcher($field='is_active', $name='Is Active', $col=6, $value=[]){
		if(empty($value)){
			$value = [
				1 => 'Active',
				0 => 'Draft',
			];
		}

		$this->field($field);
		$this->formColumn($col);
		$this->name($name);
		$this->inputType('yesno');
		$this->dataSource($value);
		$this->fallback(1);
		$this->hideExport();
		return $this;
	}

	public function autoSlug($target='title', $field='slug', $name='Slug', $col=12){
		$this->field($field);
		$this->formColumn($col);
		$this->name($name);
		$this->inputType('slug');
		$this->slugTarget($target);
		$this->setTranslate(false);
		return $this;
	}


	public function slug($field='slug', $name='Slug', $target='title', $col=12){
		$this->field($field);
		$this->formColumn($col);
		$this->name($name);
		$this->inputType('slug');
		$this->slugTarget($target);

		if(!Language::active()){
			$this->setTranslate(false);
		}

		$this->valueData(function($data, $lang=null){
			if(empty($lang)){
				$lang = config('cms.language', 'en');
			}
			if(isset($data->id)){
				return \SlugInstance::get($data, $data->id, $lang);
			}
		});
		return $this;
	}


	public function dateRange($field, $name, $callback=null){
		if(strpos($field, '[]') === false){
			$field = $field.'[]';
		}
		$this->field($field);
		$this->formColumn(12);
		$this->name($name);
		$this->inputType('daterange');
		$this->inputAttribute([
			'data-mask' => '0000-00-00'
		]);
		$this->setTranslate(false);
		$this->valueData($callback);
		return $this;
	}

	public function name($name=''){
		$this->name = $name;
		return $this;
	}

	public function orderable($orderable=true){
		$this->orderable = (bool)$orderable;
		return $this;
	}

	public function defaultOrder($dir='desc'){
		$allowed_dir = ['asc', 'desc'];
		$dir = strtolower($dir);
		if(!in_array($dir, $allowed_dir)){
			$dir = 'desc';
		}

		$this->default_order = $dir;
		return $this;
	}

	//aliasnya orderable aja
	public function sortable($var=true){
		return $this->orderable($var);
	}

	public function searchable($searchable=true){
		$this->searchable = (bool)$searchable;
		return $this;
	}

	public function dataSource($data){
		$this->data_source = $data;
		return $this;
	}


	



	//manage hide / show in table or form
	public function hideForm(){
		$this->hide_form = true;
		return $this;
	}
	
	public function hideTable(){
		$this->hide_table = true;
		return $this;
	}

	public function hideExport(){
		$this->hide_export = true;
		return $this;
	}
	
	public function exportable($bool=true){
		$this->exportable = $bool;
		return $this;
	}
	
	public function exportSearchable($bool=true){
		$this->export_searchable = $bool;
		return $this;
	}



	public function formColumn($i=12){
		$i = $i < 0 ? 1 : $i;
		$i = $i > 12 ? 12 : $i;

		$this->form_column = $i;
		return $this;
	}

	public function inputType($type='', $param=false){
		$lists = [
			'text',
			'slug',
			'number',
			'email',
			'tel',
			'password',
			'tags',
			'checkbox',
			'yesno',
			'radio',
			'textarea',
			'richtext',
			'select',
			'select_multiple',
			'image',
			'image_multiple',
			'image_simple',
			'file',
			'file_multiple',
			'date',
			'time',
			'datetime',
			'daterange',
			'view',
			'color',
			'currency',
			'map',
		];

		if(!in_array($type, $lists)){
			$type = 'text'; //paling default
		}
		if(in_array($type, ['select_multiple', 'daterange'])){
			$this->inputArray();
		}

		$this->input_type = $type;
		return $this;
	}

	public function slugTarget($target=''){
		$this->slug_target = $target;
		return $this;
	}

	public function inputArray($bool=true){
		$this->input_array = (bool)$bool;
		return $this;
	}

	public function inputAttribute($attr=[]){
		$fld = $this->field;
		$add = '';
		if(strpos($this->field, '[]') !== false){
			//kalo ada input field array, pindah ke paling ujung
			$fld = str_replace('[]', '', $this->field);
			$add = '[]';
		}

		$must = [
			'class' => ['form-control'],
			'name' => $fld.$add,
			'id' => 'input-'.$fld
		];

		$this->input_attribute = array_merge($must, $attr);
		return $this;
	}

	public function createValidation($rule='', $same_with_update=false){
		$this->create_validation = $rule;
		if($same_with_update){
			$this->updateValidation($rule);
		}
		return $this;
	}

	public function updateValidation($rule=''){
		if(strlen($rule) == 0)
			$rule = $this->create_validation; //ambil dari create validation aja sbg nilai default
		$this->update_validation = $rule;
		return $this;
	}

	public function validationTranslation($arr=[]){
		$this->validation_translation = array_merge($this->validation_translation, $arr);
		return $this;
	}

	public function valueSource($table='', $id='', $grab=''){
		$this->value_source = [$table, $id, $grab];
		return $this;
	}

    public function setTranslate($bool=false){
    	$this->translate = $bool;
    	return $this;
    }

    public function viewSource($target){
    	$this->view_source = $target;
    	return $this;
    }

    public function valueData($function){
    	$this->value_data = $function;
    	return $this;
    }
	//value data alias
	public function valueCallback($function){
		return $this->valueData($function);
	}

    public function tabGroup($tab_name){
    	$this->tab_group = $tab_name;
    	return $this;
    }

	public function showOnCreate(bool $bool){
		$this->show_on_create = $bool;
		return $this;
	}

	public function showOnUpdate(bool $bool){
		$this->show_on_update = $bool;
		return $this;
	}

	public function crudShowCondition(Closure $fn){
		$this->crud_show_condition = $fn;
		return $this;
	}

	public function tableShowCondition(Closure $fn){
		$this->table_show_condition = $fn;
		return $this;
	}

	public function view($custom_view){
		$this->view = $custom_view;
		$this->hide_table = true;
		return $this;
	}

	public function fallback($value){
		//set fallback value if inputs is empty
		$this->fallback = $value;
		return $this;
	}

}