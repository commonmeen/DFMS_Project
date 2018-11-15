<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use Session ;

class SentOTPController extends Controller
{
    public function sentOTP(Request $request){
        $data['otp'] = str_pad(rand(10000,999999), 6, '0', STR_PAD_LEFT);
        $data['expire'] = time()+(5*60);
        $data['user_Email']= Session::get('UserLogin')->user_Email;
        $data['email_Type'] = 'OTP';
        $data = (object) $data;

        userRepo::sentEmail($data,$data->user_Email);
        Session::put("otp",$data);

        return ['otp'=>$data];
    }
}
