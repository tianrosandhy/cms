<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class Image extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.image name="input_name" />
     */
    public string $view = 'core::components.input.image';

    // This component will generate a default <input type="text"> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
