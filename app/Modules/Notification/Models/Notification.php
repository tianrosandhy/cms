<?php
namespace App\Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Shared\ImageGrabable;

class Notification extends Model
{
	use ImageGrabable;

    public function sents(){
        return $this->hasMany('App\Modules\Notification\Models\NotificationSent', 'notification_id');
    }
}
