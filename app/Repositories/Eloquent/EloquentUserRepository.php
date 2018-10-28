<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
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

    public static function checkPassword($email,$pass){
        $ldap = ldap_connect("13.229.128.241",389);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        $searchOnLdap=ldap_search($ldap, "dc=ldap,dc=doculdap,dc=tk", "mail=".$email);
        $userOnLdap = ldap_get_entries($ldap, $searchOnLdap);
        if($userOnLdap['count']==0){
            return "None User" ;
        }
        if($userOnLdap[0]['userpassword'][0] == hash("sha256",$pass)){
            return $userOnLdap ;
        } else {
            return "Incorrect" ;
        }
        return "Fail" ;
    }
}
