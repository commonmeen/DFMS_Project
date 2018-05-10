<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentCategoryRepository as categoryRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class ListCatController extends Controller
{
    public function getAllCategory(Request $request)
    {
        $input = $request->all();
        $data = categoryRepo::getAllCategory();
        $flow = null ;
        if($request->has('flow_Id')){
            $flow = flowRepo::getFlowById($input['flow_Id']);
        }
        return view('AddFlow',['listCat'=>$data,'flow'=>$flow]);
    }
}
