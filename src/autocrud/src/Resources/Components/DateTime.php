<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class DateTime extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.date-time name="input_name" />
     */

    public $type = 'datetime';
    public string $view = 'core::components.input.datetime';

    // This component will generate a default input currency component with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $monthly = false,
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
