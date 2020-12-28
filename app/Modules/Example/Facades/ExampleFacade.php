<?php
namespace App\Modules\Example\Facades;

use Illuminate\Support\Facades\Facade;

class ExampleFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Example\Services\ExampleInstance::class;
    }
}
