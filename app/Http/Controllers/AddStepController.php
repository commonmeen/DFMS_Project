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
                return view('AddStep',['step'=>$next,'userList'=>$allUser, 'userPosition'=>$position , 'flow'=>$flow, 'stepData'=>null]) ;
            }
        } else {
            $oldStep = Session::get('stepEdit');  
            // check type of validator
            if($input['selectBy']=="search"){
                // check change (if not change, it should not create new version)
                if($oldStep['step_Title']==$input['title']&&$oldStep['typeOfVerify']==$input['type']&&$oldStep['validator']==$input['validator']){
                    Session::forget('stepEdit');
                    return redirect('FlowDetail?id='.$oldStep['flow_Id']);
                } else {
                    $newFlowId = flowRepo::newFlowVersion($oldStep['flow_Id']);
                    stepRepo::newStepVersion($oldStep['step_Id'],$newFlowId,$input['title'],$input['type'],"name",$input['validator'],$input['deadline']);
                    return redirect('FlowDetail?id='.$newFlowId);
                }    
            } else if($input['selectBy']=="position"){
                // check change (if not change, it should not create new version)
                if($oldStep['step_Title']==$input['title']&&$oldStep['typeOfVerify']==$input['type']&&$oldStep['validator']==[$input['position']]){
                    Session::forget('stepEdit');
                    return redirect('FlowDetail?id='.$oldStep['flow_Id']);
                } else {
                    $newFlowId = flowRepo::newFlowVersion($oldStep['flow_Id']);
                    stepRepo::newStepVersion($oldStep['step_Id'],$newFlowId,$input['title'],$input['type'],"position",[$input['position']],$input['deadline']);
                    return redirect('FlowDetail?id='.$newFlowId);
                }     
            }
        }
    }

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
