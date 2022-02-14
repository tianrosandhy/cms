<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;
 
class Tags extends BaseViewComponent
{
  /*
   * Component initialization : 
   * <x-core::input.tags name="input_name" />
   */

  public string $type = 'tags';
  public string $view = 'core::components.input.text';

  // This component will generate a default tags component input with its configuration

  public function __construct(
    public string $name,
    public $value = null,
    public array $attr = [],
    public bool $multiLanguage = false,
  ){}

}