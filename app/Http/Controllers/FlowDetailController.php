<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;

class FlowDetailController extends Controller
{
    public function detail(Request $request){
        $input = $request->all();
        $thisFlow = flowRepo::getFlowById($input['id']);
        $stepFlow = stepRepo::getStepByFlow($input['id']);
        return view('FlowDetail',['flow'=>$thisFlow,'step'=>$stepFlow]);
    }
}
