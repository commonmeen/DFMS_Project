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
        $userProfile = EloquentUserRepository::getPosition($userProfile);
        return  $userProfile;
    }

    public static function listUser()
    {
        $user = User::all();
        return json_decode($user,true);
        
    }

    public static function searchByName($word){
        $users = User::where('user_Name', 'like', $word.'%')->get();
        foreach($users as $user){
            $user = EloquentUserRepository::getPosition($user);
        }
        return json_decode($users,true);
    }

    public static function searchBySurName($word){
        $users = User::where('user_Surname', 'like', $word.'%')->get();
        foreach($users as $user){
            $user = EloquentUserRepository::getPosition($user);
        }
        return json_decode($users,true);
    }

    public static function listUserByPosition($position)
    {
        $users = User::all();
        $userThisPosition = array();
        $users = json_decode($users,true);
        foreach($users as $user){   
            foreach($user['user_Position'] as $user_Position){
                if($user_Position == $position){
                    $user = EloquentUserRepository::getPosition($user);
                    array_push($userThisPosition,$user);
                }
            }             
        }
        return $userThisPosition;
    }

    public static function getPosition($user)
    {
        $allPosition = PositionRepo::getAllPosition();
        $userPosition = array();
        foreach($user['user_Position'] as $user_Position){
            foreach($allPosition as $position){
                if($user_Position == $position->position_Id){
                    array_push($userPosition,$position->position_Name);
                }
            }
        }
        $user['user_Position'] = $userPosition ;
        return $user ;
    }
}
