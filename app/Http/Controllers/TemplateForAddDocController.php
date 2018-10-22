<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as tempRepo ;

class TemplateForAddDocController extends Controller
{
    public function templateAddDoc(){
        if(Session::has('UserLogin')){
            $tempCanUse = tempRepo::listOnTemplate();
            return view("AddDocument",['template'=>$tempCanUse]);
        } else {
            return view('Login');
        }
    }
}
