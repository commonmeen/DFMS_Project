<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Eloquent\EloquentCategoryRepository as Category;

class ListCatController extends Controller
{
    public function getAllCategory()
    {
        $data = Category::getAllCategory();
        return view('AddFlow',['listCat'=>$data]);
    }
}
