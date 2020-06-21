<?php
namespace App\Modules\Page\Facades;

use Illuminate\Support\Facades\Facade;

class PageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Page\Services\PageInstance::class;
    }
}
