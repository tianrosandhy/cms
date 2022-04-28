<?php
namespace App\Core\Facades;

use Illuminate\Support\Facades\Facade;

class ThemeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Core\Components\Themes::class;
    }
}
