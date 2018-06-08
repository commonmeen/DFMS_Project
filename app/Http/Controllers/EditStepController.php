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
        $input = $request->all();
        $thisStep = stepRepo::getStepById($input['id']);
        $flow = flowRepo::getFlowById($thisStep['flow_Id']);
        $allUser = userRepo::listUser();
        $position = positionRepo::getAllPosition();
        Session::put('stepEdit',$thisStep);
        return view('AddStep',['step'=>null, 'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>$thisStep]) ;
    }
}
