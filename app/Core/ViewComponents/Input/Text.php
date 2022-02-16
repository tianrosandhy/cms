<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;
 
class Text extends BaseViewComponent
{
  /*
   * Component initialization : 
   * <x-core::input.text name="input_name" />
   */
  public string $view = 'core::components.input.text';

  // This component will generate a default <input type="text"> with its configuration

  public function __construct(
    public string $name,
    public $value = null,
    public string $type = 'text',
    public array $attr = [],
    public bool $multiLanguage = false,
    public $data = null,
  ){}

}