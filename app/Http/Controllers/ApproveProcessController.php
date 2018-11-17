<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo;
use App\Repositories\Eloquent\EloquentNotificationRepository as notiRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class ApproveProcessController extends Controller
{
    public function approveProcess(Request $request){
        $mailSuccess = 'success';
        $mailApprove = 'approve';
        $mailReject = 'reject';      

        if(Session::has('UserLogin')){
            $input = $request->all();
            $user = Session::get('UserLogin');
            // Check Document Code
            
            $nextStep = processRepo::approve($input['pid'],$input['sid'],$user->user_Id,$input['comment'],"docCode");
            $stepObject = stepRepo::getStepById($nextStep['nextStep']);
            Session::put('alertStatus','ApproveSuccess'); 
            
            //sent email for approve process
            //$nextStep return false if don't have next step id
            //$stepObject return null if don't have next step id to query process
            if($nextStep && $stepObject != null){             
                if($stepObject['typeOfValidator'] == 'position'){
                    $validatorPositionId = $stepObject['validator'][0];
                    $data = $nextStep['process'];
                    $data->validator = json_decode(userRepo::getUserByPosition($validatorPositionId),true);
                    $data->owner = json_decode(userRepo::getUser($data->process_Owner));
                    $data->flow_Name = flowRepo::getFlowById($data->process_FlowId);
                    $data->email_Type = $mailApprove;
                    $validators = $data->validator;
                    
                    for($i=0;$i<count($validators);$i++){
                        $data->validator = $validators[$i];
                        notiRepo::addNotification($data->validator['user_Id'],"Waiting for approval",$data->flow_Name['flow_Name']." from ".$data->owner->user_Name." waiting for your approval.","/ProcessDetail?id=".$data->process_Id);
                        userRepo::sentEmail($data,$data->validator['user_Email']);
                    }
                    return ;
                } else {
                    for($i=0;$i<count($stepObject['validator']);$i++){
                        $data = $nextStep['process'];
                        $data->validator = json_decode(userRepo::getUser($stepObject['validator'][$i]),true);
                        $data->owner = json_decode(userRepo::getUser($data->process_Owner));
                        $data->flow_Name = flowRepo::getFlowById($data->process_FlowId);
                        $data->email_Type = $mailApprove;
                        notiRepo::addNotification($data->validator['user_Id'],"Waiting for approval",$data->flow_Name['flow_Name']." from ".$data->owner->user_Name." waiting for your approval.","/ProcessDetail?id=".$data->process_Id);
                        return userRepo::sentEmail($data,$data->validator['user_Email']);
                    }
                }
            }
            //sent email for success process
            else{
                $data = processRepo::getProcessById($input['pid']);
                $data['process_Owner'] = userRepo::getUser($data['process_Owner']);
                $data['flow'] = flowRepo::getFlowById($data['process_FlowId']);
                $data['email_Type'] = $mailSuccess;
                $data = (object) $data;
                notiRepo::addNotification($data->process_Owner['user_Id'],"Process Successful",$data->flow['flow_Name']." process has been successfully.","/ProcessDetail?id=".$data->process_Id);
                return userRepo::sentEmail($data,$data->process_Owner['user_Email']);
            }           
            return ;
        } else {
            return view('ErrorHandel',['errorHeader'=>"Permission denied.",'errorContent'=>'Please login.']);
        }
    }
}
