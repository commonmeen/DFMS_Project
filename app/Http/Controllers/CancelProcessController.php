<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentProcessRepository as processRepo;

class CancelProcessController extends Controller
{
    public function cancel(Request $request){
        if(Session::has("UserLogin")){
            $input = $request->all();
            processRepo::changeStatusProcess($input['process_Id'],"cancel");
            return ;
        }
    }
}
