<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;

class SentOTPController extends Controller
{
    public function sentOTP(Request $request){
        $otp['otp'] = str_pad(rand(10000,999999), 6, '0', STR_PAD_LEFT);
        $otp['expire'] = time()+(5*60);
        Session::put("otp",$otp);
        return ['otp'=>$otp];
    }
}
