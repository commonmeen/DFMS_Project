<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentStepRepository as step ;

class AddStepController extends Controller
{
    public function addStep(Request $request){
        $input = $request->all();
        $flow = Session::get('FlowCreate');
        step::addStep($input['title'],$input['type'],$flow['flow_Id'],$input['validator'],$input['deadline']);
        // $flow = $input['flow'];
        // if($input['next']==$flow['numberOfStep']){
        return    redirect('ListFlow');
        // } else {
        //     $next = $input['next']+1 ;
        //     $allUser = User::listUser();
        //     return view('AddStep',['step'=>$next,'userList'=>$allUser,'Flow'=>$flow]) ;
        // }
    }
}
