<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentNotificationRepository as notiRepo;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class RejectProcessController extends Controller
{
    public function rejectProcess(Request $request){
        if(Session::has('UserLogin')){
            $mailReject = 'reject'; 
            $input = $request->all();
            $user = Session::get('UserLogin');

            processRepo::reject($input['pid'],$input['sid'],$user->user_Id,$input['comment']);

            $data = processRepo::getProcessById($input['pid']);
            $data['process_Owner'] = userRepo::getUser($data['process_Owner']);
            $data['flow'] = flowRepo::getFlowById($data['process_FlowId']);
            $data['email_Type'] = $mailReject;
            $data = (object) $data;
            notiRepo::addNotification($data->process_Owner['user_Id'],"Process was rejected",$data->flow['flow_Name']." has been rejected.","/ProcessDetail?id=".$data->process_Id);
            Session::put('alertStatus','RejectSuccess');
            if($request->has('ErrorDocCode')){
                return redirect("/ListVerify");
            } else {
                return userRepo::sentEmail($data,$data->process_Owner['user_Email']);
            }
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login.']);
        }
    }
}
