<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class Color extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.color name="input_name" />
     */

    public string $type = 'color';
    public string $view = 'core::components.input.text';

    // This component will generate a default <input type="color"> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}