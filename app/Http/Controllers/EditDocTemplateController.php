<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentTemplateRepository as tempRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;

class EditDocTemplateController extends Controller
{
    public function editDocTemplate(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            $data = tempRepo::getTemplateById($input['temp_id']);
            $data->template_Owner = userRepo::getUser($data->template_Author);
            return view('EditDocTemplate',['data'=>$data]);
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        }
    }
}
