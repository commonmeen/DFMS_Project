<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use Validator ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo ;

class AddStepController extends Controller
{
    public function addStep(Request $request){
        $input = $request->all();
        // check add or edit step
        if($input['step']!=null){
            $flow = Session::get('FlowCreate');
            // check type of validator
            if($input['selectBy']=="search"){
                $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
                $allStepId = array();
                foreach($allStep as $step){
                    array_push($allStepId,$step['step_Id']);
                }
                if($input['step']<=count($allStep)){
                    stepRepo::editStep($allStepId[$input['step']-1],$input['title'],$input['type'],"name",$flow['flow_Id'],$input['validator'],$input['deadline']);
                }else{
                    stepRepo::addStep($input['title'],$input['type'],"name",$flow['flow_Id'],$input['validator'],$input['deadline']);
                }
            } else if($input['selectBy']=="position"){
                $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
                $allStepId = array();
                foreach($allStep as $step){
                    array_push($allStepId,$step['step_Id']);
                }
                if($input['step']<=count($allStep)){
                    stepRepo::editStep($allStepId[$input['step']-1],$input['title'],$input['type'],"position",$flow['flow_Id'],[$input['position']],$input['deadline']);
                }else{
                    stepRepo::addStep($input['title'],$input['type'],"position",$flow['flow_Id'],[$input['position']],$input['deadline']);
                }
            }
            // check step number
            if($input['step']==$flow['numberOfStep']){
                flowRepo::lockFlow($flow['flow_Id'],"on");
                Session::forget('FlowCreate');
                return    redirect('ListFlow');
            } else {
                $allStep = stepRepo::getStepByFlow($flow['flow_Id']);
                $allStepId = array();
                foreach($allStep as $step){
                    array_push($allStepId,$step['step_Id']);
                }
                $next = count($allStepId)+1 ;
                $allUser = userRepo::listUser();
                $position = positionRepo::getAllPosition();
                return view('AddStep',['allStep'=>$allStepId, 'step'=>$next, 'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>null]) ;
            }
        } else if(Session::has('stepEdit')) {
            $oldStep = Session::get('stepEdit');  
            $oldStep['flow_Id'] = $input['flow_Id'];
            // check type of validator
            if($input['selectBy']=="search"){
                // check change (if not change, it should not create new version)
                if($oldStep['step_Title']==$input['title']&&$oldStep['typeOfVerify']==$input['type']&&$oldStep['deadline']==$input['deadline']&&$oldStep['validator']==$input['validator']){
                    return redirect('EditFlow?flow_Id='.$oldStep['flow_Id'].'#flowStep');
                } else {
                    $newFlowId = flowRepo::newFlowVersion($oldStep['flow_Id']);
                    stepRepo::newStepVersion($oldStep,$newFlowId,$input['title'],$input['type'],"name",$input['validator'],$input['deadline']);
                    return redirect('EditFlow?flow_Id='.$newFlowId.'#flowStep');
                }    
            } else if($input['selectBy']=="position"){
                // check change (if not change, it should not create new version)
                if($oldStep['step_Title']==$input['title']&&$oldStep['typeOfVerify']==$input['type']&&$oldStep['deadline']==$input['deadline']&&$oldStep['validator']==[$input['position']]){
                    return redirect('EditFlow?flow_Id='.$oldStep['flow_Id'].'#flowStep');
                } else {
                    $newFlowId = flowRepo::newFlowVersion($oldStep['flow_Id']);
                    stepRepo::newStepVersion($oldStep,$newFlowId,$input['title'],$input['type'],"position",[$input['position']],$input['deadline']);
                    return redirect('EditFlow?flow_Id='.$newFlowId.'#flowStep');
                }     
            }
        } else if(Session::has('FlowEdit')){
            $newS = stepRepo::addStep("","","","","",0);
            $newS = json_decode($newS,true);
            Session::put('stepEdit',$newS);
            
            $flow = flowRepo::getFlowById($input['flow_Id']);
            $allUser = userRepo::listUser();
            $position = positionRepo::getAllPosition();
            return view('AddStep',['step'=>null, 'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>null]) ;
        }
    }

    // Validate data
    public function validateTitle(Request $request){
        $input = $request->all();
        $rules = array('title'=>'required|regex:/^([a-zA-Zก-เ])([^0-9]{0,99})$/');
        $messages = [
            'required' => 'Flow name is require.',
            'regex' => 'Flow name must be letter and not be more than 100 characters.'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails())
            echo $validator->errors()->get('title')[0];
        else
            echo "true" ;
    }

    public function validateDeadline(Request $request){
        $input = $request->all();
        $rules = array('deadline'=>'required|integer|min:1');
        $messages = [
            'required' => 'Deadline is require.',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails())
            echo $validator->errors()->get('deadline')[0];
        else
            echo "true" ;
    }
}
