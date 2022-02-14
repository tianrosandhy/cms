<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;

class Yesno extends BaseViewComponent
{
  /*
   * Component initialization : 
   * <x-core::input.yesno name="input_name" />
   */
  public string $view = 'core::components.input.yesno';

  // This component will generate a default <switchery yesno> component with its configuration

  public function __construct(
    public string $name,
    public $value = null,
    public array $attr = [],
    public bool $multiLanguage = false,
  ){}

}