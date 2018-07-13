<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo ;

class NewProcessController extends Controller
{
    public function newProcess(Request $request){
        $input = $request->all();
        $user = Session::get('UserLogin');
        if(!Session::has('fileUploaded'))
            $fileName = [] ;
        else
            $fileName = Session::get('fileUploaded');
        $process = processRepo::newProcess($input['name'],$user->user_Id,$input['flowId'],$input['document_Id'],$fileName,$input['textProcess']);
        Session::forget('fileUploaded');
        return redirect('ListProcess');
    }
}
