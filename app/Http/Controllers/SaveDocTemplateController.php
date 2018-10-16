<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo ;

class SaveDocTemplateController extends Controller
{
    public function saveTemplate(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $temp = templateRepo::addTemplate($request->input('title'),Session::get('UserLogin')->user_Id,$request->input('desc'),$request->input('formData'));
            return ['temp'=>$temp];
        }
    }
}
