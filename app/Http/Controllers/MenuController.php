<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as UserRepo;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $id = 'U00001';
        // $id = $request->input('id');
        $data = UserRepo::getUser($id);
        if($data!=null){
            Session::put('UserLogin',$data);
            return view('Home',['data'=>$data]);
        }
        return ;
    }
}
