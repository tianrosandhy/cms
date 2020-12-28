<?php
namespace App\Modules\Notification\Models;

use App\Core\Models\BaseModel;
use App\Core\Shared\ImageGrabable;

class Notification extends BaseModel
{
	use ImageGrabable;

    public function sents(){
        return $this->hasMany('App\Modules\Notification\Models\NotificationSent', 'notification_id');
    }
}
