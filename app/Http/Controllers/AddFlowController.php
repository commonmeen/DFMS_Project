<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as Flow ;
use App\Repositories\Eloquent\EloquentTemplateRepository as Template;

class AddFlowController extends Controller
{
    public function addFlow(Request $request){
        $input = $request->all();
        $newFlowId = Flow::addFlow($input['name'],$input['author'],$input['desc'],$input['catId'],$input['deadline'],$input['numberOfStep']);
        $thisFlow = Flow::getFlowById($newFlowId);
        $allTemplate = Template::listTemplate();
        return view('AddFlowTemplate',['Flow'=>$thisFlow,'template'=>$allTemplate]);
    }
}
