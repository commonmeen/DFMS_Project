<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;
use App\Repositories\Eloquent\EloquentNotificationRepository as notiRepo ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;

class NewProcessController extends Controller
{
    public function newProcess(Request $request){
        if(Session::has('UserLogin')){
            $mailApprove = 'approve';
            $input = $request->all();
            $user = Session::get('UserLogin');
            if(!Session::has('fileUploaded'))
                $fileName = [] ;
            else
                $fileName = Session::get('fileUploaded');
            $str = "";
            foreach($input['document_Id'] as $doc_Id){
                docRepo::changeStatus($doc_Id,"used");
                foreach (docRepo::getDocumentById($doc_Id)['data'] as $data){
                    if(is_array($data['detail'])){
                        foreach($data['detail'] as $d){
                            $str = $str.$d ;
                        }
                    } else {
                        $str = $str.$data['detail'] ;
                    }
                    $str = $str.$data['name'] ;
                }
            }
            $docCode = hash("md5",$str."DFMS");
            $process = processRepo::newProcess($user->user_Id,$input['flowId'],$input['document_Id'],$fileName,$input['textProcess'],$docCode);
            $processObject = json_decode($process);
            $stepObject = stepRepo::getStepById($processObject->current_StepId);
            if($stepObject['typeOfValidator'] == 'position'){
                $validatorPositionId = $stepObject['validator'][0];
                $data = $processObject;
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
            } else {
                for($i=0;$i<count($stepObject['validator']);$i++){
                    $data = $processObject;
                    $data->validator = json_decode(userRepo::getUser($stepObject['validator'][$i]),true);
                    $data->owner = json_decode(userRepo::getUser($data->process_Owner));
                    $data->flow_Name = flowRepo::getFlowById($data->process_FlowId);
                    $data->email_Type = $mailApprove;
                    notiRepo::addNotification($data->validator['user_Id'],"Waiting for approval",$data->flow_Name['flow_Name']." from ".$data->owner->user_Name." waiting for your approval.","/ProcessDetail?id=".$data->process_Id);
                    userRepo::sentEmail($data,$data->validator['user_Email']);
                }
            }
            Session::forget('NewProcess');
            Session::forget('fileUploaded');
            return redirect('ListProcess')->with('alertStatus', 'Success');
        } else {
            return view('Login');
        }
    }
}