<?php
namespace TianRosandhy\Autocrud\InputGenerator\Components;

use TianRosandhy\Autocrud\InputGenerator\BaseViewComponent;

class Checkbox extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.number name="input_name" />
     */

    public string $type = 'checkbox';
    public string $view = 'core::components.input.radio';

    // This component will generate a default <input type="number"> with its configuration

    public function __construct(
        public string $name,
        public $source,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
