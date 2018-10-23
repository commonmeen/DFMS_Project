<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo ;
use Debugbar;

class LockTemplateController extends Controller
{
    public function lockTemplate(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            templateRepo::changeStatus($input['template_id'],$input['newStatus']);
            return ;
        }
    }
}