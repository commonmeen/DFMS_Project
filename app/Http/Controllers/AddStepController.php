<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;

class AddStepController extends Controller
{
    public function addStep(Request $request){
        $input = $request->all();
        $flow = Session::get('FlowCreate');
        stepRepo::addStep($input['title'],$input['type'],$flow['flow_Id'],$input['validator'],$input['deadline']);
        if($input['step']==$flow['numberOfStep']){
            return    redirect('ListFlow');
        } else {
            $next = $input['step']+1 ;
            $allUser = userRepo::listUser();
            $position = userRepo::getPosition();
            return view('AddStep',['step'=>$next,'userList'=>$allUser, 'userPosition'=>$position]) ;
        }
    }
}
