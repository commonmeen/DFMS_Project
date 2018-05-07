<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as userRepo;

class SearchUserController extends Controller
{
    public function searchUser(Request $request){
        $input = $request->all();
        $name = userRepo::searchByName($input['search']);
        $surname = userRepo::searchBySurname($input['search']);
        $all = array_collapse([$name,$surname]);
        $all = array_unique($all,0);
        return ['searchAll'=>$all] ;
    }

    public function searchPosition(Request $request){
        $input = $request->all();
        $user = userRepo::listUserByPosition($input['position_Id']);
        return ['searchAll'=>$user] ;
    }

}
