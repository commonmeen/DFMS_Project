<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Position;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Eloquent\EloquentPositionRepository as PositionRepo;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentUserRepository extends AbstractRepository implements UserRepository
{
    public function entity()
    {
        return User::class;
    }

    public static function getUser($userId){
        $userProfile = User::where('user_Id', '=', $userId)->first();
        $allPosition = PositionRepo::getAllPosition();
        $userPosition = array();
        foreach($userProfile['user_Position'] as $user_position){
            foreach($allPosition as $position){
                if($user_position == $position->position_Id){
                    array_push($userPosition,$position->position_Name);
                }
            }
        }
        $userProfile['user_Position'] = $userPosition ;
        return  json_decode($userProfile);
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

    public static function listUserByPosition($position)
    {
        $user = User::where('user_Position',$position)->get();
        return json_decode($user,true);
    }

    public static function getPosition()
    {
        $user = User::distinct('user_Position')->get();
        return json_decode($user,true);
    }
}
