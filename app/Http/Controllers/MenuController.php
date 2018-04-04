<?php

namespace App\Http\Controllers;

class MenuController extends Controller
{
    protected $userRepo;

    public static function getMenu()
    {
        $data = $this->$userRepo->checkRole($user_id);
        return $data;
    }
}
