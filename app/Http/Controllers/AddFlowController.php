<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentFlowRepository as Flow ;
use App\Repositories\Eloquent\EloquentTemplateRepository as Template;

class AddFlowController extends Controller
{
    public function addFlow(Request $request){
        $input = $request->all();
        $user = Session::get('UserLogin');
        $newFlowId = Flow::addFlow($input['name'],$user->user_Id,$input['desc'],$input['catId'],$input['deadline'],$input['numberOfStep']);
        $thisFlow = Flow::getFlowById($newFlowId);
        Session::put('FlowCreate',$thisFlow);
        $allTemplate = Template::listTemplate();
        return view('ListTemplate',['Flow'=>$thisFlow,'template'=>$allTemplate]);
    }
}
