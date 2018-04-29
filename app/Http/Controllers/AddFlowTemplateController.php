<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as Flow ;
use App\Repositories\Eloquent\EloquentUserRepository as User ;

class AddFlowTemplateController extends Controller
{
    public function addFlowTemplate(Request $request){
        $input = $request->all();
        Flow::addFlowTemplate($input['flow_Id'],$input['template_Id']);
        $next = 1 ;
        $allUser = User::listUser();
        $position = User::getPosition();
        return view('AddStep',['step'=>$next,'userList'=>$allUser, 'userPosition'=>$position]) ;
    }
}
