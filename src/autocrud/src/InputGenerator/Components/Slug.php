<?php
namespace TianRosandhy\Autocrud\InputGenerator\Components;

use TianRosandhy\Autocrud\InputGenerator\BaseViewComponent;

class Slug extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.slug name="input_name" />
     */
    public string $view = 'core::components.input.slug';

    // This component will generate a default <input type="slug"> with its configuration

    public function __construct(
        public string $name,
        public string $slugTarget,
        public $value = null,
        public string $type = 'text',
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
