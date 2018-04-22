<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentStepRepository as step ;

class AddStepController extends Controller
{
    public function addStep(Request $request){
        $input = $request->all();
        step::addStep($input['title'],$input['type'],$input['flow_id'],$input['validator'],$input['deadline']);
        $flow = $input['flow'];
        if($input['next']==$flow['numberOfStep']){
            return view('ListFlow') ;
        } else {
            $next = $input['next']+1 ;
            $allUser = User::listUser();
            return view('AddStep',['step'=>$next,'userList'=>$allUser,'Flow'=>$flow]) ;
        }
    }
}
