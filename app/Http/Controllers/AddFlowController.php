<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use Validator ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo;

class AddFlowController extends Controller
{
    public function addFlow(Request $request){
        if(Session::has('UserLogin')){
            if(Session::get('UserLogin')->user_Role=="manager"){
                $input = $request->all();
                $allStepId = array() ;
                if($request->has('flow')){
                    if($request->has('name')){
                        $flow = flowRepo::editFlow($input['flow'],$input['name'],$input['desc'],$input['catId'],$input['numberOfStep'],$input['attachRequire']);
                        if(Session::has('FlowEdit')){
                            Session::forget('FlowEdit');
                            return redirect('FlowDetail?id='.$input['flow']);
                        }
                    }
                    $thisFlow = flowRepo::getFlowById($input['flow']);
                    if(!Session::has('FlowCreate')){
                        $thisFlow['numberOfStep'] = 0 ;
                    }else{
                        $allStep = stepRepo::getStepByFlow($input['flow']);
                        foreach($allStep as $step){
                            array_push($allStepId,$step['step_Id']);
                        }
                        Session::put('FlowCreate',$thisFlow);
                    }
                } else {
                    $user = Session::get('UserLogin');
                    $newFlowId = flowRepo::addFlow($input['name'],$user->user_Id,$input['desc'],$input['catId'],$input['numberOfStep'],$input['attachRequire']);
                    $thisFlow = flowRepo::getFlowById($newFlowId);
                    Session::put('FlowCreate',$thisFlow);
                }
                $allTemplate = templateRepo::listTemplate();
                return view('ListTemplate',['Flow'=>$thisFlow,'template'=>$allTemplate, 'allStepId'=>$allStepId]);       
            } else {
                return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
            }
        } else {
            return view('Login');
        }
    }
    ///////////////////////// Validate data ///////////////////////
    public function validateName(Request $request){
        $input = $request->all();
        $rules = array('name'=>'required|regex:/^([a-zA-Zก-เ])([^0-9]{0,99})$/');
        $messages = [
            'required' => 'Flow name is require.',
            'regex' => 'Flow name must be letter and not be more than 100 characters.'
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails())
            echo $validator->errors()->get('name')[0];
        else
            echo "true" ;
    }

    public function validateNumberOfStep(Request $request){
        $input = $request->all();
        $rules = array('numberOfStep'=>'required|numeric|min:1');
        $messages = [
            'required' => 'Number of Step is require.',
        ];
        $validator = Validator::make($input, $rules, $messages);
        if($validator->fails())
            echo $validator->errors()->get('numberOfStep')[0];
        else
            echo "true" ;
    }
}
