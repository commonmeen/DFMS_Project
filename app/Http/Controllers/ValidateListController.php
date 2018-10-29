<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;

class ValidateListController extends Controller
{
    public function listProcessForValidate(){
        if(Session::has('UserLogin')){
            $user = Session::get('UserLogin');
            $validator = validatorRepo::getValidateByUserId($user->user_Id);
            $allStepData = array();
            $position_Id = $user->user_Position ;
            foreach($position_Id as $pos_Id){
                $position = positionRepo::getPositionById($pos_Id);
                foreach($position['validate_Step'] as $vaStep_Id){
                    array_push($allStepData,stepRepo::getStepById($vaStep_Id));
                }
            }
            if($validator == null){
                if(count($allStepData)==0){
                    return view('ListVerify',['nowProcess'=>array(),'rejectProcess'=>array(),'passMeProcess'=>array(),'comingProcess'=>array()]);
                }
            } else {
                foreach($validator['step_Id'] as $stepId){
                    array_push($allStepData,stepRepo::getStepById($stepId));
                }
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
                $processOwner = userRepo::getUser($process['process_Owner']);
                $flowOnProcess = flowRepo::getFlowById($process['process_FlowId']);
                $process['flowObject'] = $flowOnProcess ;
                $process['ownerObject'] = $processOwner ;
                if($process['current_StepId'] == "reject"){
                    array_push($reject,$process);
                // Cancel process is not nessesery to show 
                } else if($process['current_StepId'] == "cancel"){
                //     array_push($reject,$process);
                } else {
                    $i = 0 ;
                    foreach($allStepData as $step){
                        if($step['step_Id'] == $process['current_StepId']){
                            array_push($now,$process);
                            $i = 1 ;
                            break ;
                        } else {
                            foreach($process['process_Step'] as $passStep){
                                if($passStep['step_Id'] == $step['step_Id']){
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
            return view('ListVerify',['nowProcess'=>$now,'rejectProcess'=>$reject,'passMeProcess'=>$passMe,'comingProcess'=>$coming]);
        } else {
            return view('Login');
        }
    }
}