<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;

class ApproveProcessController extends Controller
{
    public function approveProcess(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            $user = Session::get('UserLogin');
            // Check Document Code
            processRepo::approve($input['pid'],$input['sid'],$user->user_Id,$input['comment'],"docCode");
            return ;
        } else {
            dd("Error occur", "Permission denied. Plz login on manager role.");
        }
    }
}
