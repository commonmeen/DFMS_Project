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
        return ['name'=>$name,'surname'=>$surname] ;
    }

}
