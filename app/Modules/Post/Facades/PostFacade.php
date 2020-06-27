<?php
namespace App\Modules\Post\Facades;

use Illuminate\Support\Facades\Facade;

class PostFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Post\Services\PostInstance::class;
    }
}
