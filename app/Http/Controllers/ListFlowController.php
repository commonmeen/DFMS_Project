<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as Flow;
class ListFlowController extends Controller
{
    public function listFlow(){
        $data = Flow::getFlowGroupCat();
        return view('ListFlow',['allFlow'=>$data]);
    }
}
