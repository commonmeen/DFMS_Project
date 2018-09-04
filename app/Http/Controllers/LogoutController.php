<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request){
        Session::flush();
        return view('Login')->with("Err","");
    }
}
