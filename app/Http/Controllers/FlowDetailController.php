<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentTemplateRepository as templateRepo ;
use App\Repositories\Eloquent\EloquentCategoryRepository as catRepo ;

class FlowDetailController extends Controller
{
    public function detail(Request $request){
        if(Session::has('UserLogin')){
            if(Session::get('UserLogin')->user_Role=="manager"){
                $input = $request->all();
                $thisFlow = flowRepo::getFlowById($input['id']);
                $arrayTemplateName = array();
                $thisFlow['flow_CatId'] = catRepo::getCatById($thisFlow['flow_CatId'])->cat_Name;
                foreach($thisFlow['template_Id'] as $template_Id){
                $temp = templateRepo::getTemplateById($template_Id);
                array_push($arrayTemplateName,$temp->template_Name);
                }
                $thisFlow['template_Id'] = $arrayTemplateName ;
                $stepFlow = stepRepo::getStepByFlow($input['id']);
                return view('FlowDetail',['flow'=>$thisFlow,'step'=>$stepFlow]);
            } else {
                dd("Error occur", "Permission denied. Plz login on manager role.");
            }
        } else {
            return view('Login');
        }
    }
}
