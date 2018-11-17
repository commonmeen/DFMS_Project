<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session ;
use App\Repositories\Eloquent\EloquentCategoryRepository as catRepo ;

class AddCatController extends Controller
{
    public static function addCat(Request $request)
    {
        if(Session::has('UserLogin') && Session::get('UserLogin')->user_Role=="manager"){
            $input = $request->all();
            $data = catRepo::getAllCategory();
            foreach($data as $cat){
                if($cat['cat_Name']==$input['cat_Name']){
                    return ['listCat'=>null];
                }
            }
            catRepo::addCat($input['cat_Name']);
            $data = catRepo::getAllCategory();
            return ['listCat'=>$data];
        } else {
            return view('ErrorHandel',['errorHeader'=>'Permission denied.','errorContent'=>'Please login on manager role.']);
        }
    }
}
