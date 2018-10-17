<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $catFlow = flowRepo::getFlowGroupCat();
        if(Session::has('UserLogin')){
            $id = Session::get('UserLogin')->user_Id;
            $data = userRepo::getUser($id);
            $processes = processRepo::getProcessByOwner($id);
            $validator = validatorRepo::getValidateByUserId($id);
            // Flow process
            for($i=0; $i < count($processes) ; $i++){
                $processes[$i]['numberOfStep'] = flowRepo::getFlowById($processes[$i]['process_FlowId'])['numberOfStep'];
            }
            // Verify process
            $now = array();
            if($validator != null){
                $allProcessCanApprove = array();
                $allStepData = array();
                foreach($validator['step_Id'] as $stepId){
                    array_push($allStepData,stepRepo::getStepById($stepId));
                }
            
                foreach($allStepData as $stepData){
                    $allProcessCanApprove = array_add($allProcessCanApprove,$stepData['flow_Id'],processRepo::getProcessByFlow($stepData['flow_Id']));
                }
                $allProcessCanApprove = array_collapse($allProcessCanApprove);
                foreach($allProcessCanApprove as $process){
                    $flowOnProcess = flowRepo::getFlowById($process['process_FlowId']);
                    $process['flowObject'] = $flowOnProcess ;
                    foreach($validator['step_Id'] as $step_Id){
                        if($step_Id == $process['current_StepId']){
                            array_push($now,$process);
                            break ;
                        }
                    }
                }
            }
            
            if($data!=null){
                return view('Home',['data'=>$data,'catFlow'=>$catFlow, 'allProcess'=>$processes ,'nowProcess'=>$now]);
            }
        } else if($request->has('email')) {
            $passStatus = userRepo::checkPassword($request->input('email'),$request->input('password'));
            if($passStatus == "None User"){
                $errMessage = "Don't have this E-mail on our organization, Please contact the administrator.";
                return view('Login', ['Err'=>$errMessage]);
            } else if($passStatus == "Incorrect"){
                $errMessage = "Password incorrect, Please try agian.";
                return view('Login', ['Err'=>$errMessage]);
            } else {
                $data = userRepo::getUser($passStatus[0]['uid'][0]);
                if($data != null){
                    Session::put('UserLogin',$data);
                    return redirect('/');
                } else{
                    $errMessage = "Don't have user in database, Please contact the administrator.";
                    return view('Login', ['Err'=>$errMessage]);  
                }
            }
        }else {
            return view('Login');
        }
        return ;
    }
}