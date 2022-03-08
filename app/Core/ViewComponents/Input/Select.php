<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class Select extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.select name="input_name" :source=[array] />
     */
    public string $type = 'select'; //select
    public string $view = 'core::components.input.select';

    // This component will generate a default <select> with its configuration

    public function __construct(
        public string $name,
        public $source,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
