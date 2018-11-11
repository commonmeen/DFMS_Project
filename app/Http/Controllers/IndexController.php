<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class IndexController extends Controller
{
    public function checkAuth(){
        if(Session::has('UserLogin')){
            return redirect('/');
        }
        else {
            return view('Login');
        }
    }
    
}
