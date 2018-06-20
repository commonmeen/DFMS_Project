<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo ;

class ProcessDetailController extends Controller
{
    public function processDetail(Request $request){
        $input = $request->all();
        $thisProcess = processRepo::getProcessById($input['id']);
        $stepFlow = stepRepo::getStepByFlow($thisProcess['process_FlowId']);
        $flow = flowRepo::getFlowById($thisProcess['process_FlowId']);
        $thisProcess['process_FlowName'] = $flow['flow_Name'] ;
        $documentName = array();
        foreach ($thisProcess['data']['document_Id'] as $docId){
            $doc = docRepo::getDocumentById($docId);
            array_push($documentName,$doc['document_Name']);
        }
        $thisProcess['data']['document_Name'] = $documentName ;
        return view('ProcessDetail',['process'=>$thisProcess,'steps'=>$stepFlow]);
    }
} 
