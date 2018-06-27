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
        if($input['file'][0] == null)
            $input['file'] = [] ;
        $process = processRepo::newProcess($input['name'],$user->user_Id,$input['flowId'],$input['document_Id'],$input['file'],$input['textProcess']);
        return redirect('ListProcess');
    }
}
