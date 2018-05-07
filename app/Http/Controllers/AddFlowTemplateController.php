<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo ;

class AddFlowTemplateController extends Controller
{
    public function addFlowTemplate(Request $request){
        $input = $request->all();
        if ($request->has('template_Id')){
            flowRepo::addFlowTemplate($input['flow_Id'],$input['template_Id']);
        }
        $next = 1 ;
        $allUser = userRepo::listUser();
        $position = positionRepo::getAllPosition();
        return view('AddStep',['step'=>$next,'userList'=>$allUser, 'userPosition'=>$position]) ;
    }
}
