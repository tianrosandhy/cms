<?php
namespace App\Modules\Navigation\Facades;

use Illuminate\Support\Facades\Facade;

class NavigationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Navigation\Services\NavigationInstance::class;
    }
}
