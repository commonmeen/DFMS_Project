<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentCategoryRepository as catRepo ;

class AddCatController extends Controller
{
    public static function addCat(Request $request)
    {
        $input = $request->all();
        catRepo::addCat($input['cat_Name']);
        $data = catRepo::getAllCategory();
        return ['listCat'=>$data];
    }
}
