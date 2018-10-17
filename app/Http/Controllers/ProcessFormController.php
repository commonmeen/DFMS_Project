<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class ProcessFormController extends Controller
{
    public function newProcessForm(){
        if(Session::has("UserLogin")){
            $flow = flowRepo::listFlowCanUse();
            $catFlow = flowRepo::getFlowGroupCat();
            return view('DataProcess',['flows'=>$flow, 'catFlow'=>$catFlow]);
        } else {
            return view('Login');
        }
    }
}
