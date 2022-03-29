<?php
namespace TianRosandhy\Autocrud\Facades;

use App\Core\Facades\RefreshableFacade;

class Input extends RefreshableFacade
{
    protected static function getFacadeAccessor()
    {
        return \TianRosandhy\Autocrud\InputGenerator\Input::class;
    }
}

