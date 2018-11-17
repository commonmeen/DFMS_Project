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
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        }
    }
}
