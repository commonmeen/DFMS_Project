<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo ;
class SaveDocTemplateController extends Controller
{
    public function saveTemplate(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $session = Session::get('tempStatus');
            if($session == 'AddTemplate'){
                $temp = templateRepo::addTemplate($request->input('title'),Session::get('UserLogin')->user_Id,$request->input('desc'),$request->input('formData'));
                return ['temp'=>$temp];
            }
            else{
                $data = $request->all();
                $data['template_Id'] = Session::get('tempStatus');
                $temp = templateRepo::editTemplate($data);
                Session::forget('tempStatus');
                return ['temp'=>$temp];
            }
        }
    }
}
