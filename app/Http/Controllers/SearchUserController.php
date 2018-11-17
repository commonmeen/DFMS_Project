<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log ;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;

class SearchUserController extends Controller
{
    public function searchUser(Request $request){
        $input = $request->all();
        $checked = array();
        if($request->has('checked')){
            foreach($input['checked'] as $id_check){
                array_push($checked,userRepo::getPosition(userRepo::getUser($id_check)));
            }
        }
        $name = userRepo::searchByName($input['search']);
        $surname = userRepo::searchBySurname($input['search']);
        $all = array_collapse([$name,$surname]);
        $all = array_unique($all,0);
        foreach($checked as $user_check){
            foreach($all as $user_search){
                $i = array_search($user_check->user_Id,$user_search);
                $key = array_keys($all,$user_search);
                if($i == "user_Id"){
                    array_splice($all,$key[0],1);
                }
            }
        }
        return ['searchAll'=>$all,'checked'=>$checked] ;
    }

    public function searchPosition(Request $request){
        $input = $request->all();
        $user = userRepo::listUserByPosition($input['position_Id']);
        return ['searchAll'=>$user] ;
    }

    public function getValidator(Request $request){
        $input = $request->all();
        $user = array() ;
        foreach($input['userIds'] as $uid){
            array_push($user,userRepo::getUser($uid));
        }
        return ['searchAll'=>$user] ;
    }

}
