<?php

namespace App\Repositories\Eloquent;

use App\Category;
use App\Repositories\Contracts\CategoryRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;
use App\Models\Category as CategoryModel;

class EloquentCategoryRepository extends AbstractRepository implements CategoryRepository
{
    public function entity()
    {
        return Category::class;
    }

    public static function getAllCategory()
    {
        $data = CategoryModel::all();
        $arrayOfData = json_decode($data,true);
        return $arrayOfData;
    }

    
    public static function addCat($name)
    {
        $prev = Category::orderBy('created_at','desc')->take(1)->get();
        $newId = 'C'.str_pad(substr($prev[0]->cat_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $category = new Category;
        $category->cat_Id = $newId;
        $category->cat_Name = $name;
        $category->save();
    }
}
