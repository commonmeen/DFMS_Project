<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as UserRepo;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $id = $request->input('id');
        $data = UserRepo::getUser($id);
        if($data!=null){
            Session::put('UserLogin',$data);
            if($data->user_Role == "manager"){
                return view('manager_menu',['data'=>$data]);
            }else
                return view('user_menu');
        }
        return ;
    }
}
