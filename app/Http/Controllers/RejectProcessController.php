<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentNotificationRepository as notiRepo;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class RejectProcessController extends Controller
{
    public function rejectProcess(Request $request){
        if(Session::has('UserLogin')){
            $mailReject = 'reject'; 
            $input = $request->all();
            $user = Session::get('UserLogin');
            $str = "";
            $thisProcess = processRepo::getProcessById($input['pid']);
            foreach($thisProcess['data']['document_Id'] as $doc_Id){
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
            if($docCode == $thisProcess['data']['docCode'] || $request->has('ErrorDocCode')){
                processRepo::reject($input['pid'],$input['sid'],$user->user_Id,$input['comment'],$docCode);

                $data = processRepo::getProcessById($input['pid']);
                $data['process_Owner'] = userRepo::getUser($data['process_Owner']);
                $data['flow'] = flowRepo::getFlowById($data['process_FlowId']);
                $data['email_Type'] = $mailReject; 
                $data = (object) $data;
                notiRepo::addNotification($data->process_Owner['user_Id'],"Process was rejected",$data->flow['flow_Name']." has been rejected.","/ProcessDetail?id=".$data->process_Id);
            } else {
                return ["ErrorDocCode"=>true];
            }
            if($request->has('ErrorDocCode')){
                Session::put('alertStatus','ErrorDocCode');
                return redirect("/ListVerify");
            } else {
                Session::put('alertStatus','RejectSuccess');
                return userRepo::sentEmail($data,$data->process_Owner['user_Email']);
            }
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login.']);
        }
    }
}
