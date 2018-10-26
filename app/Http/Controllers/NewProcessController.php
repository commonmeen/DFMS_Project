<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;
use App\Repositories\Eloquent\EloquentDocumentRepository as docRepo ;

class NewProcessController extends Controller
{
    public function newProcess(Request $request){
        if(Session::has('UserLogin')){
            $input = $request->all();
            $user = Session::get('UserLogin');
            if(!Session::has('fileUploaded'))
                $fileName = [] ;
            else
                $fileName = Session::get('fileUploaded');
            $process = processRepo::newProcess($input['name'],$user->user_Id,$input['flowId'],$input['document_Id'],$fileName,$input['textProcess']);
            foreach($input['document_Id'] as $doc_Id){
                docRepo::changeStatus($doc_Id,"used");
            }
            Session::forget('fileUploaded');
            return redirect('ListProcess');
        } else {
            return view('Login');
        }
    }
}
