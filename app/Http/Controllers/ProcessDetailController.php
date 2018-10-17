<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;
use App\Repositories\Eloquent\EloquentStepRepository as stepRepo ;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo ;

class ProcessDetailController extends Controller
{
    public function processDetail(Request $request){
        $input = $request->all();
        $thisProcess = processRepo::getProcessById($input['id']);
        $stepFlow = stepRepo::getStepByFlow($thisProcess['process_FlowId']);
        $flow = flowRepo::getFlowById($thisProcess['process_FlowId']);
        $thisProcess['process_FlowName'] = $flow['flow_Name'] ;
        for ($i = 0 ; $i < count($thisProcess['process_Step']) ; $i++){
            $thisProcess['process_Step'][$i]['approver_Detail'] = json_decode(userRepo::getUser($thisProcess['process_Step'][$i]['validator_Id']),true);
        }
        $documentName = array();
        $documentObject = array();
        foreach ($thisProcess['data']['document_Id'] as $docId){
            $doc = docRepo::getDocumentById($docId);
            array_push($documentName,$doc['document_Name']);
            array_push($documentObject,$doc);
        }
        $thisProcess['data']['document_Name'] = $documentName ;
        $processOwner =  json_decode(userRepo::getUser($thisProcess['process_Owner']));
        $canApprove = false ;
        if($request->has("InProgress")){
            $canApprove = true ;
        }

        return view('ProcessDetail',['process'=>$thisProcess,'steps'=>$stepFlow,'canApprove'=>$canApprove, 'owner'=>$processOwner, 'document'=>$documentObject]);
    }
} 
