<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo ;

class EditStepController extends Controller
{
    public function editStep(Request $request){
        if(Session::has('UserLogin')){
            if(Session::get('UserLogin')->user_Role=="manager"){
                $input = $request->all();
                $thisStep = stepRepo::getStepById($input['id']);        
                $flow = flowRepo::getFlowById($thisStep['flow_Id']);
                $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
                $allUser = userRepo::listUser();
                $position = positionRepo::getAllPosition();
                if(Session::has('FlowCreate')){
                    $allStepId = array();
                    foreach($allStep as $step){
                        array_push($allStepId,$step['step_Id']);
                    }
                    return view('AddStep',['allStep'=>$allStepId, 'step'=>$input['stepck'], 'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>$thisStep]) ;
                } else {
                    Session::put('stepEdit',$thisStep);
                    $number = array_search($thisStep,$allStep)+1;
                    return view('AddStep',['step'=>null, 'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>$thisStep , 'stepNumber'=>$number]) ;
                }
            } else 
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        } else 
        return view('Login');
    }
}
