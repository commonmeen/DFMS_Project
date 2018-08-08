<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;

class ValidateListController extends Controller
{
    public function listProcessForValidate(){
        $user = Session::get('UserLogin');
        $validator = validatorRepo::getValidateByUserId($user->user_Id);
        $allStepData = array();
        foreach($validator['step_Id'] as $stepId){
            array_push($allStepData,stepRepo::getStepById($stepId));
        }
        $allProcessCanApprove = array();
        foreach($allStepData as $stepData){
            $allProcessCanApprove = array_add($allProcessCanApprove,$stepData['flow_Id'],processRepo::getProcessByFlow($stepData['flow_Id']));
        }
        $allProcessCanApprove = array_collapse($allProcessCanApprove);
        $now = array();
        $reject = array();
        $passMe = array();
        $coming = array();
        foreach($allProcessCanApprove as $process){
            if($process['current_StepId'] == "reject"){
                array_push($reject,$process);
            // } else if($process['current_StepId'] == "cancel"){
            //     array_push($reject,$process);
            } else {
                $i = 0 ;
                foreach($validator['step_Id'] as $step_Id){
                    if($step_Id == $process['current_StepId']){
                        array_push($now,$process);
                        $i = 1 ;
                        break ;
                    } else {
                        foreach($process['process_Step'] as $passStep){
                            if($passStep['step_Id'] == $step_Id){
                                array_push($passMe,$process);
                                $i = 1 ;
                                break;
                            }
                        }
                    }
                }
                if($i == 0){
                    $process['process_Flow'] = flowRepo::getFlowById($process['process_FlowId']);
                    array_push($coming,$process);
                }
            }
        }
        // dd($allProcessCanApprove,$allStepData,$now,$reject,$passMe,$coming);
        return view('ListVerify',['nowProcess'=>$now,'rejectProcess'=>$reject,'passMeProcess'=>$passMe,'comingProcess'=>$coming]);
    }
}