<?php

namespace App\Http\Controllers;

use Session ;
use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;

class MenuController extends Controller
{
    public function getMenu(Request $request)
    {
        $id = 'U00001';
        // $id = $request->input('id');
        $catFlow = flowRepo::getFlowGroupCat();
        $data = userRepo::getUser($id);
        if($data!=null){
            Session::put('UserLogin',$data);
            return view('Home',['data'=>$data,'catFlow'=>$catFlow]);
        }
        return ;
    }
}
