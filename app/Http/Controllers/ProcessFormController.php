<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class ProcessFormController extends Controller
{
    public function newProcessForm(){
        $flow = flowRepo::listFlowCanUse();
        $catFlow = flowRepo::getFlowGroupCat();
        return view('DataProcess',['flows'=>$flow, 'catFlow'=>$catFlow]);
    }
}
