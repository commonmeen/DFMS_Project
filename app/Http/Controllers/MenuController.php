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
        $catFlow = flowRepo::getFlowGroupCat();
        if(Session::has('UserLogin')){
            $id = Session::get('UserLogin')->user_Id;
            $data = userRepo::getUser($id);
            if($data!=null){
                return view('Home',['data'=>$data,'catFlow'=>$catFlow]);
            }
        } else if($request->has('username')) {
            $passStatus = userRepo::checkPassword($request->input('username'),$request->input('password'));
            if($passStatus == "None User"){
                return view('Login')->with("Err","Don't have this E-mail on our organization, Please contact the administrator.");
            } else if($passStatus == "Incorrect"){
                return view('Login')->with("Err","Password incorrect, Please try agian.");
            } else {
                $data = userRepo::getUser($passStatus[0]['uid'][0]);
                if($data!=null){
                    Session::put('UserLogin',$data);
                    return view('Home',['data'=>$data,'catFlow'=>$catFlow]);
                } else {
                    return view('Login')->with("Err","Don't have user in database, Please contact the administrator.");
                }
            }
        } else {
            return view('Login')->with("Err","");
        }
        return ;
    }
}