<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;

class ClearSessionController extends Controller
{
    public function test($key)
    {
        if (Session::has($key))
        {
            Session::forget($key);
        }
        return ;
    }
}