<?php

namespace App\Repositories\Eloquent;

use App\Models\Flow;
use App\Repositories\Contracts\FlowRepository;
use App\Repositories\Eloquent\EloquentCategoryRepository ;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentFlowRepository extends AbstractRepository implements FlowRepository
{
    public function entity()
    {
        return Flow::class;
    }

    public function listFlow(){
        $data = Flow::all();
        return json_decode($data);    
    }

    public static function getFlowGroupCat(){
        $allCat = EloquentCategoryRepository::getAllCategory();
        $flowGroupCat = array() ;
        foreach($allCat as $cat){
            $data = Flow::where('flow_CatId', '=', $cat['cat_Id'])->get();
            $data = json_decode($data,true);
            $flowGroupCat = array_add($flowGroupCat, $cat['cat_Id'],$data);
        }
        return $flowGroupCat ;
    }
}
