<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentUserRepository extends AbstractRepository implements UserRepository
{
    public function entity()
    {
        return User::class;
    }

    public static function getUser($userId){
        $user = User::where('user_Id', '=', $userId)->first();
        return json_decode($user) ;
    }

    public static function listUser()
    {
        $user = User::all();
        return json_decode($user,true);
        
    }

    public static function searchByName($word){
        $user = User::where('user_Name', 'like', $word.'%')->get();
        return json_decode($user,true);
    }

    public static function searchBySurName($word){
        $user = User::where('user_Surname', 'like', $word.'%')->get();
        return json_decode($user,true);
    }
}
