<?php
namespace TianRosandhy\Autocrud\InputGenerator\Components;

use TianRosandhy\Autocrud\InputGenerator\BaseViewComponent;

class Password extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.password name="input_name" />
     */
    public string $view = 'core::components.input.text';
    public string $type = 'password';

    // This component will generate a default <input type="password"> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}