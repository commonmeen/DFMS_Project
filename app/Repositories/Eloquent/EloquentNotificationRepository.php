<?php

namespace App\Repositories\Eloquent;

use App\Models\Notification;
use App\Repositories\Contracts\NotificationRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentNotificationRepository extends AbstractRepository implements NotificationRepository
{
    public function entity()
    {
        return Notification::class;
    }

    public static function getNotiByUserId($user_Id){
        $noti = Notification::where('user_Id',$user_Id)->get();
        return json_decode($noti,true);
    }
}
