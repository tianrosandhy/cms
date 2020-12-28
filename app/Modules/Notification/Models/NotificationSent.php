<?php
namespace App\Modules\Notification\Models;

use App\Core\Models\BaseModel;

class NotificationSent extends BaseModel
{
    protected $fillable = [
        'notification_id',
        'user_id',
        'push_token',
        'status',
        'read_at',
        'created_at',
        'updated_at',
    ];

    public function notification(){
        return $this->belongsTo('App\Modules\Notification\Models\Notification', 'notification_id');
    }
}
