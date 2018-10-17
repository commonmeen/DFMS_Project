<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class GetFlowDocumentController extends Controller
{
    public function getDoc(Request $request){
        if(Session::has('UserLogin')){
            $input = $request->all();
            $flow = flowRepo::getFlowById($input['flow_Id']);
            $user = Session::get('UserLogin');
            $document = docRepo::listDocumentByUserId($user->user_Id);
            $document = docRepo::filterDocumentByFlow($flow,$document);
            return ['documentList'=>$document] ;
        }
    }
}
