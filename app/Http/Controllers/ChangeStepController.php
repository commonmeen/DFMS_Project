<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;

class ChangeStepController extends Controller
{
    public function changeStepSave(Request $request){
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            if(Session::has('FlowEdit')){
                $flow = Session::get('FlowEdit');
                if(Session::has('stepChange')){
                    $stepChange = Session::get('stepChange');
                    $numberOfStep = count($stepChange);
                    $newFlowId = flowRepo::newFlowVersion($flow['flow_Id']);
                    flowRepo::setNumOfStep($newFlowId,$numberOfStep);
                    foreach($stepChange as $step){
                        stepRepo::changeStepVersion($step,$newFlowId);
                    }
                    Session::forget('FlowEdit');
                    Session::forget('stepChange');
                    return ['newFlowId'=>$newFlowId];
                } else {
                    return ['newFlowId'=>$flow['flow_Id']];
                }
            } else {
                return view('ErrorHandel',['errorHeader'=>"This page can't load.",'errorContent'=>'Session not found.']);
            }
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        }
    }

    public function changeStep(Request $request){
        $input = $request->all();
        $flow = Session::get('FlowEdit');
        if(Session::has('stepChange')){
            $allStep = Session::get('stepChange');
        } else {
            $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
        }        
        $i = 0 ;
        foreach($allStep as $step){
            if($step['step_Id'] == $input['step_Id']){
                if($input['status'] == "delete"){
                    for($i;$i+1<count($allStep);$i++){
                        $allStep[$i] = $allStep[$i+1] ;
                    }
                    array_forget($allStep,$i);
                    break; 
                } else if($input['status'] == "plus") {
                    $allStep[$i] = $allStep[$i+1] ;
                    $allStep[$i+1] = $step ;
                    break ;
                } else if($input['status'] == "minus") {
                    $allStep[$i] = $allStep[$i-1] ;
                    $allStep[$i-1] = $step ;
                    break ;
                }
            }
            $i++ ;
        }     
        Session::put('stepChange',$allStep);
        return ['step'=>$allStep];
    }
}