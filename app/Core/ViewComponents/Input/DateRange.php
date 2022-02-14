<?php
namespace App\Core\ViewComponents\Input;

use App\Core\Base\ViewComponents\BaseViewComponent;
 
class DateRange extends BaseViewComponent
{
  /*
   * Component initialization : 
   * <x-core::input.date-range name="input_name" />
   */
  public string $view = 'core::components.input.daterange';

  // This component will generate a default input currency component with its configuration

  public function __construct(
    public string $name,
    public array $value = [], // value must be in ["start_date", "end_date"] format.
    public array $attr = [],
    public bool $monthly = false,
    public bool $multiLanguage = false,
  ){}
}