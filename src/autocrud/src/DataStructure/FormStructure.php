<?php
namespace TianRosandhy\Autocrud\DataStructure;

class FormStructure extends BaseDataStructure
{
    public function __construct()
    {
        $this->struct_type = 'form';
    }

    /**
     * @param (int) set the CRUD field width in bootstrap column format (1-12). (Default = 12)
     */
    public int $form_column = 12;

    /**
     * @param (array) append the input in CRUD with this attribute
     * array format is : ["attr_name" => "value", "another_attr_name" => "another_value"]
     */
    public array $input_attribute = [];

    /**
     * @param (bool) manage the CRUD label visibility (default = true)
     */ 
    public bool $show_label = true;

    /** 
     * @param (string) append string note on below CRUD input
     */
    public string $notes;

    /**
     * We can set the initial / default value of the input by passing the Closure that return the value
     */
    public Closure $value_data;

    /**
     * @param (bool) Mark if the input in this CRUD form is multiple language or not
     */
    public bool $translateable = false;

    /**
     * @param (string) Set the tab group name
     */
    public string $tab_group = 'General';
    
    /**
     * @param (string) Set the custom value path for the input
     */
    public string $view;

    /**
     * @param (string|array) Pass a validation string or array to be validated via laravel's Validator class
     */
    public $validation;

    /**
     * @param (array) Pass a custom validation translation to process logic.
     * Array format is : ["field_name.validation_name" => "translation_data"]
     */    
    public array $validation_translation;

    
}