<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;

class RejectProcessController extends Controller
{
    public function rejectProcess(Request $request){
        $input = $request->all();
        $user = Session::get('UserLogin');
        processRepo::reject($input['pid'],$input['sid'],$user->user_Id,$input['comment']);
        return ;
    }
}
