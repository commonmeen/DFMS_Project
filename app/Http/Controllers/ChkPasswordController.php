<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;

class ChkPasswordController extends Controller
{
    public function chkPassword(Request $request){
        $passStatus = userRepo::checkPassword(Session::get('UserLogin')->user_Email,$request->input('password'));
        if (!is_string($passStatus)){
            return ['status'=>true] ;
        }
        return ['status'=>false] ;
    }
}
