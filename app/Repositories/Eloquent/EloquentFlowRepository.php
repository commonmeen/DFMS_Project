<?php

namespace App\Repositories\Eloquent;

use App\Models\Flow;
use App\Repositories\Contracts\FlowRepository;
use App\Repositories\Eloquent\EloquentCategoryRepository;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentFlowRepository extends AbstractRepository implements FlowRepository
{
    public function entity()
    {
        return Flow::class;
    }

    public function listFlow()
    {
        $data = Flow::all();
        return json_decode($data);
    }

    public static function getFlowGroupCat()
    {
        $allCat = EloquentCategoryRepository::getAllCategory();
        $flowGroupCat = array();
        foreach ($allCat as $cat) {
            $data = Flow::where('flow_CatId', '=', $cat['cat_Id'])->get();
            $data = json_decode($data, true);
            $flowGroupCat = array_add($flowGroupCat, $cat['cat_Name'], $data);
        }
        return $flowGroupCat;
    }

    public static function addFlow($name,$author,$desc,$catId,$deadline,$noStep){
        $prev = Flow::orderBy('created_at','desc')->take(1)->get();
        $newId = 'F'.str_pad(substr($prev[0]->flow_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $flow = new Flow ;
        $flow->flow_Id = $newId ;
        $flow->flow_Name = $name ;
        $flow->flow_Author = $author ;
        $flow->flow_Description = $desc ;
        $flow->flow_CatId = $catId ;
        $flow->flow_Deadline = $deadline ;
        $flow->numberOfStep = $noStep ;
        $flow->time_AVG = 0 ;
        $flow->template_Id = [];
        $flow->save();   
        return $newId;
    }
}
