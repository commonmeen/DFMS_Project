<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo ;

class AddStepController extends Controller
{
    public function addStep(Request $request){
        $input = $request->all();
        $flow = Session::get('FlowCreate');
        // check type of validator
        if($input['selectBy']=="search"){
            stepRepo::addStep($input['title'],$input['type'],"name",$flow['flow_Id'],$input['validator'],$input['deadline']);
        } else if($input['selectBy']=="position"){
            stepRepo::addStep($input['title'],$input['type'],"position",$flow['flow_Id'],[$input['position']],$input['deadline']);
        }
        // check step number
        if($input['step']==$flow['numberOfStep']){
            Session::forget('FlowCreate');
            return    redirect('ListFlow');
        } else {
            $next = $input['step']+1 ;
            $allUser = userRepo::listUser();
            $position = positionRepo::getAllPosition();
            return view('AddStep',['step'=>$next,'userList'=>$allUser, 'userPosition'=>$position]) ;
        }
    }
}
