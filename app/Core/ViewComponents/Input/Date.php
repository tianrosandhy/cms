<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;
 
class Date extends BaseViewComponent
{
  /*
   * Component initialization : 
   * <x-core::input.date name="input_name" />
   */

  public $type = 'date';
  public string $view = 'core::components.input.datetime';

  // This component will generate a default input currency component with its configuration

  public function __construct(
    public string $name,
    public $value = null,
    public array $attr = [],
    public bool $monthly = false,
    public bool $multiLanguage = false,
    public $data = null,
  ){}

}