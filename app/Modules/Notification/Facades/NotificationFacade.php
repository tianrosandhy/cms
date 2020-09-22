<?php
namespace App\Modules\Notification\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Modules\Notification\Services\NotificationInstance::class;
    }
}
