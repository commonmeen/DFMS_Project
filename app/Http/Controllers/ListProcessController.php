<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;

class ListProcessController extends Controller
{
    public function listProcess(){
        if(Session::has('UserLogin')){
            $user = Session::get('UserLogin');
            $processes = processRepo::getProcessByOwner($user->user_Id); 
            $processWithFlow = array();
            foreach($processes as $process => $flow_Id){
                $flow = flowRepo::getFlowById($flow_Id['process_FlowId']);
                $flow_Id['process_Flow'] = $flow ;
                array_push($processWithFlow,$flow_Id );
            }
            return view('ListProcess',['allProcess'=>$processWithFlow]);
        } else {
            return view('Login');
        }
    }
}
