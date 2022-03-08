<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class FileMultiple extends BaseViewComponent
{
    /*
     * Component initialization :
     * <x-core::input.file-multiple name="input_name" />
     */

    public string $type = 'multiple';
    public string $view = 'core::components.input.file';

    // This component will generate a default <input type="file"> with its configuration

    public function __construct(
        public string $name,
        public $value = null,
        public array $attr = [],
        public bool $multiLanguage = false,
        public $data = null,
    ) {}

}
