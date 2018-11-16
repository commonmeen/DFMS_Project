<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CategoryRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;
use App\Models\Category ;

class EloquentCategoryRepository extends AbstractRepository implements CategoryRepository
{
    public function entity()
    {
        return Category::class;
    }

    public static function getAllCategory()
    {
        $data = Category::all();
        $arrayOfData = json_decode($data,true);
        return $arrayOfData;
    }

    
    public static function addCat($name)
    {
        $prev = Category::orderBy('cat_Id','desc')->take(1)->get();
        $newId = 'C'.str_pad(substr($prev[0]->cat_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $category = new Category;
        $category->cat_Id = $newId;
        $category->cat_Name = $name;
        $category->save();
    }

    public static function getCatById($id){
        $data = Category::where('cat_Id',$id)->first();
        return json_decode($data);
    }
}
