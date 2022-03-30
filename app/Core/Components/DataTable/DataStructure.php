<?php
namespace App\Core\Components\DataTable;

use App\Core\Shared\DynamicProperty;
use Closure;
use DB;
use Input;
use Autocrud;
use SlugInstance;

class DataStructure
{
    use DynamicProperty;

    // basic
    public $field; // (string) the field name that will be used in CRUD input and table field id
    public $name; // (string) the human-readable name that will be shown as table header / form label
    public $default_order; // (bool) default order of data (asc/desc) - default = desc

    // datatable
    public $orderable; // (bool) set current field can be ordered (default = true)
    public $searchable; // (bool) set current field can be filtered (default = true)
    public $hide_table; // (bool) remove current field in DataTable (default = false)
    public $hide_form; // (bool) remove current field in CRUD (default = false)
    public $order_override; // (string|Closure) if you want to override the default order field name. Default : order by $field
    public $search_override; // (Closure) if you want to override the search filter behavior of this field. Default : filter by $field

    // exporter
    public $exportable; // (bool) set the current field can be exported (default = true)
    public $export_searchable; // (bool) set the current field can be filtered in export modal (default = true)
    public $hide_export; // (bool) remove current field in Export fields (defult = false)

    // CRUD visibility
    public $show_on_create; // (bool) set the current CRUD field is shown in create mode (default = true)
    public $show_on_update; // (bool) set the current CRUD field is shown in update mode (default = true)
    public $crud_show_condition; // (Closure) set current field in CRUD visibility by closure that return bool
    public $table_show_condition; // (Closure) set current field in DataTable visibility by closure that return bool

    // form & input
    public $form_column; // (int) set the CRUD field width in bootstrap column format (1-12). (Default = 12)
    public $input_type; // (string) set the input type based on Input::class
    public $input_attribute; // (array) append the input in CRUD with this attribute
    public $input_array; // mark that the current input is array or single input (default = false)
    public $show_label; // (bool) manage the CRUD label visibility (default = true)
    public $notes; // (string) append string note on below CRUD input

    // validation
    public $create_validation; // (string) the Validation rule string that will be applied in CRUD create mode
    public $update_validation; // (string) the Validation rule string that will be applied in CRUD update mode
    public $validation_translation; // (array) the Validation translation override that will be applied in CRUD when processed

    public $slug_target; // (string) Only used when $input_type="slug". Fill with target Input::class $field name, so slug will be automatically created based on that field 
    public $data_source; // (array|Closure) The data source for multiple value input like "select", "checkbox", "radio". (Mandatory)
    public $value_data; // (Closure) set the current CRUD input default value data.
    public $translate; // (bool) mark this field as translateable or not (default = true)
    public $view_source; // (string) Mandatory when you use $input_type="view". Fill the view path target of the custom input
    public $tab_group; // (string) Set the CRUD tab group name if you want to have multiple tab form. (Default = null)
    public $view; // (string) Append custom view in CRUD.  
    public $fallback; // (any) Set the fallback value of current input

    public function __construct()
    {
        //manage default value
        $this->orderable = true;
        $this->searchable = true;
        $this->exportable = true;
        $this->export_searchable = true;
        $this->hide_form = false;
        $this->hide_table = false;
        $this->order_override = null;
        $this->search_override = null;
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
        $this->translate = true;
        $this->tab_group = 'General';
        $this->validation_translation = [];
        $this->view = null;
        $this->fallback = null;
        $this->show_label = true;
        $this->notes = null;
    }

    public function createInput($data = null, $multi_language = false)
    {
        $config = [
            'type' => $this->input_type,
            'name' => $this->field,
            'attr' => $this->input_attribute,
            'data' => $data,
            'value' => $this->generateStoredValue($data, $multi_language),
        ];

        if ($this->input_type == 'slug') {
            $config['slug_target'] = $this->slug_target;
        }
        if (in_array($this->input_type, ['select', 'select_multiple', 'radio', 'checkbox'])) {
            $config['source'] = $this->data_source;
        }
        if ($this->view_source) {
            $config['view_source'] = $this->view_source;
        }

        if ($multi_language) {
            return Input::multiLanguage()->type($this->input_type, $this->field, $config);
        } else {
            return Input::type($this->input_type, $this->field, $config);
        }
    }

    protected function generateStoredValue($data, $multi_language = false)
    {
        $field_name = $this->field;
        if (strpos($field_name, '[]') !== false) {
            $field_name = str_replace('[]', '', $field_name);
        }
        if ($this->value_data) {
            if ($multi_language) {
                foreach (Autocrud::langs() as $lang => $langlabel) {
                    $value[$lang] = call_user_func($this->value_data, $data, $lang);
                }
            } else {
                $value = call_user_func($this->value_data, $data);
            }
        } else {
            if ($multi_language) {
                foreach (Autocrud::langs() as $lang => $langlabel) {
                    $value[$lang] = isset($data->{$field_name}) ? $data->outputTranslate($field_name, $lang, true) : null;
                }
            } else {
                $value = isset($data->{$field_name}) ? $data->{$field_name} : null;
            }
        }

        //grab from fallback if empty value
        if (empty($value)) {
            if (is_string($value) && strlen($value) > 0) {
                // anjir lah.. "0" dibaca empty sama php dong -_-
                return $value;
            }
            $value = $this->fallback;
        }

        return $value;
    }

    public function field($field = '')
    {
        $this->field = $field;
        $this->inputAttribute();
        return $this;
    }

    //quick structure
    public function checker($name = 'id')
    {
        $this->field($name);
        $this->orderable(false);
        $this->searchable(false);
        $this->exportable(false);
        $this->hideExport(true);
        $this->name('<input type="checkbox" name="checker_all" id="checker_all_datatable">');
        $this->hideForm();
        return $this;
    }

    public function switcher($field = 'is_active', $name = 'Is Active', $col = 6, $value = [])
    {
        if (empty($value)) {
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

    public function autoSlug($target = 'title', $field = 'slug', $name = 'Slug', $col = 12)
    {
        $this->field($field);
        $this->formColumn($col);
        $this->name($name);
        $this->inputType('slug');
        $this->slugTarget($target);
        $this->setTranslate(false);
        return $this;
    }

    public function slug($field = 'slug', $name = 'Slug', $target = 'title', $col = 12)
    {
        $this->field($field);
        $this->formColumn($col);
        $this->name($name);
        $this->inputType('slug');
        $this->slugTarget($target);

        if (!Autocrud::activeLang()) {
            $this->setTranslate(false);
        }

        $this->valueData(function ($data, $lang = null) {
            if (empty($lang)) {
                $lang = Autocrud::defaultLang();
            }
            if (isset($data->id)) {
                return SlugInstance::get($data, $data->id, $lang);
            }
        });
        return $this;
    }

    public function dateRange($field, $name, $callback = null)
    {
        if (strpos($field, '[]') === false) {
            $field = $field . '[]';
        }
        $this->field($field);
        $this->formColumn(12);
        $this->name($name);
        $this->inputType('daterange');
        $this->inputAttribute([
            'data-mask' => '0000-00-00',
        ]);
        $this->setTranslate(false);
        $this->valueData($callback);
        return $this;
    }

    public function image($field, $label)
    {
        $this->field($field);
        $this->name($label);
        $this->inputType('image');
        $this->exportable(false);
        $this->searchable(false);
        $this->orderable(false);
        $this->setTranslate(false);
        return $this;
    }

    // end quick structure

    public function name($name = '')
    {
        $this->name = $name;
        return $this;
    }

    public function showLabel($show_condition=true)
    {
        $this->show_label = $show_condition;
        return $this;
    }

    public function notes($notes=null)
    {
        $this->notes = $notes;
        return $this;
    }

    public function orderable($orderable = true)
    {
        $this->orderable = (bool) $orderable;
        return $this;
    }

    public function defaultOrder($dir = 'desc')
    {
        $allowed_dir = ['asc', 'desc'];
        $dir = strtolower($dir);
        if (!in_array($dir, $allowed_dir)) {
            $dir = 'desc';
        }

        $this->default_order = $dir;
        return $this;
    }

    //aliasnya orderable aja
    public function sortable($var = true)
    {
        return $this->orderable($var);
    }

    public function searchable($searchable = true)
    {
        $this->searchable = (bool) $searchable;
        $this->export_searchable = (bool) $searchable;
        return $this;
    }

    public function dataSource($data)
    {
        $this->data_source = $data;
        return $this;
    }

    //manage hide / show in table or form
    public function hideForm()
    {
        $this->hide_form = true;
        return $this;
    }

    public function hideTable()
    {
        $this->hide_table = true;
        $this->hide_export = true;
        return $this;
    }

    public function hideExport()
    {
        $this->hide_export = true;
        return $this;
    }

    public function exportable($bool = true)
    {
        $this->exportable = $bool;
        return $this;
    }

    public function exportSearchable($bool = true)
    {
        $this->export_searchable = $bool;
        return $this;
    }

    public function formColumn($i = 12)
    {
        $i = $i < 0 ? 1 : $i;
        $i = $i > 12 ? 12 : $i;

        $this->form_column = $i;
        return $this;
    }

    public function inputType($type = '', $param = false)
    {
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

        if (!in_array($type, $lists)) {
            $type = 'text'; //paling default
        }
        if (in_array($type, ['select_multiple', 'daterange'])) {
            $this->inputArray();
        }

        $this->input_type = $type;
        return $this;
    }

    public function slugTarget($target = '')
    {
        $this->slug_target = $target;
        return $this;
    }

    public function inputArray($bool = true)
    {
        $this->input_array = (bool) $bool;
        return $this;
    }

    public function inputAttribute($attr = [])
    {
        $fld = $this->field;
        $add = '';
        if (strpos($this->field, '[]') !== false) {
            //kalo ada input field array, pindah ke paling ujung
            $fld = str_replace('[]', '', $this->field);
            $add = '[]';
        }

        $must = [
            'class' => ['form-control'],
            'name' => $fld . $add,
            'id' => 'input-' . $fld,
        ];

        $this->input_attribute = array_merge($must, $attr);
        return $this;
    }

    public function createValidation($rule = '', $same_with_update = false)
    {
        $this->create_validation = $rule;
        if ($same_with_update) {
            $this->updateValidation($rule);
        }
        return $this;
    }

    public function updateValidation($rule = '')
    {
        if (strlen($rule) == 0) {
            $rule = $this->create_validation;
        }
        //ambil dari create validation aja sbg nilai default
        $this->update_validation = $rule;
        return $this;
    }

    public function validationTranslation($arr = [])
    {
        $this->validation_translation = array_merge($this->validation_translation, $arr);
        return $this;
    }

    public function setTranslate($bool = false)
    {
        $this->translate = $bool;
        return $this;
    }

    public function viewSource($target)
    {
        $this->view_source = $target;
        return $this;
    }

    public function valueData($function)
    {
        $this->value_data = $function;
        return $this;
    }
    //value data alias
    public function valueCallback($function)
    {
        return $this->valueData($function);
    }

    public function tabGroup($tab_name)
    {
        $this->tab_group = $tab_name;
        return $this;
    }

    public function showOnCreate(bool $bool)
    {
        $this->show_on_create = $bool;
        return $this;
    }

    public function showOnUpdate(bool $bool)
    {
        $this->show_on_update = $bool;
        return $this;
    }

    public function crudShowCondition(Closure $fn)
    {
        $this->crud_show_condition = $fn;
        return $this;
    }

    public function tableShowCondition(Closure $fn)
    {
        $this->table_show_condition = $fn;
        return $this;
    }

    public function searchOverride(Closure $fn)
    {
        $this->search_override = $fn;
        return $this;
    }

    public function orderOverride($fn)
    {
        $this->order_override = $fn;
        return $this;
    }

    public function view($custom_view)
    {
        $this->view = $custom_view;
        $this->hide_table = true;
        return $this;
    }

    public function fallback($value)
    {
        //set fallback value if inputs is empty
        $this->fallback = $value;
        return $this;
    }

}
