<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentCategoryRepository as catRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentTemplateRepository as tempRepo;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo;

class EditFlowManageController extends Controller
{
    public function editFlow(Request $request){
        if(Session::has('stepEdit')){
            if(Session::get('stepEdit')['step_Title']=="")
                stepRepo::deleteStep(Session::get('stepEdit')['step_Id']);
            Session::forget('stepEdit');
        }
        if(Session::has('stepChange'))
            Session::forget('stepChange');
        $input = $request->all();
        $cats = catRepo::getAllCategory();
        $flow = flowRepo::getFlowById($input['flow_Id']);
        $allTemplate = tempRepo::listTemplate();
        $stepFlow = stepRepo::getStepByFlow($flow['flow_Id']);
        Session::put('FlowEdit',$flow);
        return view('EditFlow',['listCat'=>$cats,'flow'=>$flow,'template'=>$allTemplate,'step'=>$stepFlow]);
    }
}