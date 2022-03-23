<?php
namespace TianRosandhy\Autocrud\InputGenerator\Components;

use TianRosandhy\Autocrud\InputGenerator\BaseViewComponent;

class Richtext extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.richtext name="input_name" />
     */
    public string $view = 'core::components.input.richtext';

    // This component will generate a default <textarea data-tinymce> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
