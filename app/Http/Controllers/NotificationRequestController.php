<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentNotificationRepository as notiRepo ;

class NotificationRequestController extends Controller
{
    public function getNoti(Request $request){
        if(Session::has('UserLogin')){
            $notiThisUser = notiRepo::getNotiByUserId(Session::get('UserLogin')->user_Id);
            $countUnread = 0 ;
            foreach($notiThisUser as $noti){
                if($noti['status']=="unread"){
                    $countUnread++ ;
                } 
            }
            return ["noti"=>$notiThisUser, "count"=>$countUnread];
        } else {
            dd("Error occur", "Plz login.");
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login.']);
        }
    }

    public function readNoti(Request $request){
        $input = $request->all();
        notiRepo::changeToRead($input['noti_Id']);
        return ;
    }
}
