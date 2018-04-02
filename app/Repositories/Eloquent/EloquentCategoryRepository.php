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
}
