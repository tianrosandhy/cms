<?php
namespace TianRosandhy\Autocrud\InputGenerator\Components;

use TianRosandhy\Autocrud\InputGenerator\BaseViewComponent;

class Textarea extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.textarea name="input_name" />
     */
    public string $view = 'core::components.input.textarea';

    // This component will generate a default <textarea> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
