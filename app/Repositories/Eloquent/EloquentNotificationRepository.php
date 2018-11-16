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

    public static function addNotification($user_Id,$header,$detail,$link){
        $prev = Notification::orderBy('notification_Id','desc')->take(1)->get();
        $newId = 'N'.str_pad(substr($prev[0]->notification_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $noti = new Notification ;
        $noti->notification_Id = $newId ;
        $noti->user_Id = $user_Id ;
        $noti->header = $header ;
        $noti->detail = $detail ;
        $noti->link = $link ;
        $noti->status = "unread" ;
        $noti->save() ;
        return $noti ;
    }

    public static function changeToRead($noti_Id){
        $noti = Notification::where('notification_Id',$noti_Id)->first();
        $noti->status = "read";
        $noti->save();
        return ;
    }
}
