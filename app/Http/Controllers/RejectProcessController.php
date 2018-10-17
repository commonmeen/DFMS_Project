<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;

class RejectProcessController extends Controller
{
    public function rejectProcess(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            $user = Session::get('UserLogin');
            processRepo::reject($input['pid'],$input['sid'],$user->user_Id,$input['comment']);
            return ;
        } else {
            dd("Error occur", "Permission denied. Plz login on manager role.");
        }
    }
}
