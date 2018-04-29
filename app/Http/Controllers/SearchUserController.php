<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as user;

class SearchUserController extends Controller
{
    public function searchUser(Request $request){
        $input = $request->all();
        $name = user::searchByName($input['search']);
        $surname = user::searchBySurname($input['search']);
        $all = array_collapse([$name,$surname]);
        $all = array_unique($all,0);
        return ['searchAll'=>$all] ;
    }

}
