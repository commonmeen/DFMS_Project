<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;

class LockFlowController extends Controller
{
    public function lockFlow(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            flowRepo::lockFlow($input['flow_id'],$input['newStatus']);
            return ;
        }
    }
}
