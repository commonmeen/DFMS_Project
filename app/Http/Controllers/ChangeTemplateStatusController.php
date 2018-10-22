<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo;

class ChangeTemplateStatusController extends Controller
{
    public function changeStatusTemplate(Request $request){
        if(Session::has('Login') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            templateRepo::changeStatus($input['template_id'],$input['newStatus']);
            return ;
        } else {
            dd("Error occur", "Permission denied. Plz login on manager role.");
        }
    }
}
