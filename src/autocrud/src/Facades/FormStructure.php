<?php
namespace TianRosandhy\Autocrud\Facades;

use App\Core\Facades\RefreshableFacade;

class FormStructure extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \TianRosandhy\Autocrud\DataStructure\FormStructure::class;
    }
}
