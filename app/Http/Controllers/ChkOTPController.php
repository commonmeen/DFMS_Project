<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;

class ChkOTPController extends Controller
{
    public function chkOTP(Request $request){
        if(Session::has("otp")){
            $otp = Session::get("otp");
            if (time() < $otp['expire']){
                if($request->input('otp')==$otp['otp']){
                    Session::forget("otp");
                    return ['status'=>true] ;
                } else {
                    return ['status'=>false] ;
                }
            } else {
                Session::forget("otp");
                return ['status'=>false] ;
            }
        }
        return ['status'=>false] ;
    }
}
