<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentUserRepository as UserRepo;

class MenuController extends Controller
{
    public function getMenu($id)
    {
        $data = UserRepo::getUser($id);
        if($data->user_Role == "manager"){
            return view('manager_menu');
        }else
            return view('user_menu');
    }
}
