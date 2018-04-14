<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentCategoryRepository as Category ;

class AddCatController extends Controller
{
    public static function AddCat(Request $request)
    {
        Category::addCat($request->input('name'));
        return ;
    }
}
