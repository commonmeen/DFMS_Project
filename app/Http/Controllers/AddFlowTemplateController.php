<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo ;

class AddFlowTemplateController extends Controller
{
    public function addFlowTemplate(Request $request){
        if(Session::has('UserLogin')){
            if(Session::get('UserLogin')->user_Role=="manager"){
                $input = $request->all();
                if($request->has('flow_Id')){
                    if ($request->has('template_Id')){
                        flowRepo::addFlowTemplate($input["flow_Id"],$input['template_Id']);
                    } else {
                        flowRepo::addFlowTemplate($input["flow_Id"],[]);
                    }
                    Session::forget('FlowEdit');
                    return redirect()->route('FlowDetail',['id'=>$input["flow_Id"]]);
                }else if(Session::has('FlowCreate')){
                    $flow = Session::get('FlowCreate');
                    if ($request->has('template_Id')){
                        flowRepo::addFlowTemplate($flow["flow_Id"],$input['template_Id']);
                    } else {
                        flowRepo::addFlowTemplate($flow["flow_Id"],[]);
                    }
                    $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
                    $allStepId = array();
                    foreach($allStep as $step){
                        array_push($allStepId,$step['step_Id']);
                    }
                    $next = count($allStepId)+1 ;
                    $allUser = userRepo::listUser();
                    $position = positionRepo::getAllPosition();
                    return view('AddStep',['allStep'=>$allStepId, 'step'=>$next,'userList'=>$allUser, 'userPosition'=>$position, 'flow'=>$flow, 'stepData'=>null]) ;
                } else {
                    dd("Error occur","Page can't load, Session not found.");
                }
            } else {
                dd("Error occur", "Permission denied. Plz login on manager role.");
            }
        } else {
            return view('Login');
        }
    }
}
