<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo;

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
            $allStepData = array();
            $position_Id = $data->user_Position ;
            foreach($position_Id as $pos_Id){
                $position = positionRepo::getPositionById($pos_Id);
                foreach($position['validate_Step'] as $vaStep_Id){
                    array_push($allStepData,stepRepo::getStepById($vaStep_Id));
                }
            }
            $allProcessCanApprove = array();
            if($validator != null){
                foreach($validator['step_Id'] as $stepId){
                    array_push($allStepData,stepRepo::getStepById($stepId));
                }
            }
            foreach($allStepData as $stepData){
                $allProcessCanApprove = array_add($allProcessCanApprove,$stepData['flow_Id'],processRepo::getProcessByFlow($stepData['flow_Id']));
            }
            $allProcessCanApprove = array_collapse($allProcessCanApprove);
            foreach($allProcessCanApprove as $process){
                $flowOnProcess = flowRepo::getFlowById($process['process_FlowId']);
                $processOwner = userRepo::getUser($process['process_Owner']);

                $process['flowObject'] = $flowOnProcess ;
                $process['owner'] = $processOwner->user_Name.' '.$processOwner->user_Surname ;
                // dd($process);
                
                foreach($allStepData as $step){
                    if($step['step_Id'] == $process['current_StepId']){
                        array_push($now,$process);
                        break ;
                    }
                }
            }
            $data = userRepo::getPosition($data);
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