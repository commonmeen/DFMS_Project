<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
class AddDocTemplateController extends Controller
{
    public function addTemplate(){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            return view('AddDocTemplate');
        }
        else {
            dd("Error occur", "Permission denied. Plz login on manager role.");
        }
    }
}
