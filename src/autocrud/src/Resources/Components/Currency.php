<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class Currency extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.currency name="input_name" />
     */
    public string $view = 'core::components.input.currency';

    // This component will generate a default input currency component with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}