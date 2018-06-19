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

    public static function listFlowCanUse()
    {
        $data = Flow::where('status',"on")->get();
        return json_decode($data);
    }

    public static function getFlowById($id){
        $flow = Flow::where('flow_Id',$id)->first();
        return json_decode($flow,true);
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
        $flow->numberOfUse = 0 ;
        $flow->template_Id = [];
        $flow->status = "on";
        $flow->save();   
        return $newId;
    }

    public static function addFlowTemplate($id,$template){
        $flow = Flow::where('flow_Id',$id)->first();
        $flow->template_Id = $template ;
        $flow->save();
    }

    public static function lockFlow($id,$status){
        $flow = Flow::where('flow_Id',$id)->first();
        $flow->status = $status ;
        $flow->save();
    }

    public static function editFlow($id,$name,$desc,$catId,$deadline,$noStep)
    {
        $flow = Flow::where('flow_Id',$id)->first();
        $flow->flow_Name = $name;
        $flow->flow_Description = $desc;
        $flow->flow_CatId = $catId;
        $flow->flow_Deadline = $deadline;
        $flow->numberOfStep = $noStep ;
        $flow->save(); 
        return $flow;
    }

    public static function newFlowVersion($oldFlowId){
        $prev = Flow::orderBy('created_at','desc')->take(1)->get();
        $newId = 'F'.str_pad(substr($prev[0]->flow_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $newFlow = new Flow ;
        $newFlow->flow_Id = $newId ;
        $newFlow->save();
        $oldFlow = Flow::where('flow_Id',$oldFlowId)->first();
        $oldFlow->status = $newId ;
        $oldFlow->save();
        $newFlow->flow_Name = $oldFlow->flow_Name;
        $newFlow->flow_Author = $oldFlow->flow_Author ;
        $newFlow->flow_Description = $oldFlow->flow_Description ;
        $newFlow->flow_CatId = $oldFlow->flow_CatId ;
        $newFlow->flow_Deadline = $oldFlow->flow_Deadline ;
        $newFlow->numberOfStep = $oldFlow->numberOfStep ;
        $newFlow->time_AVG = $oldFlow->time_AVG ;
        $newFlow->numberOfUse = $oldFlow->numberOfUse ;
        $newFlow->template_Id = $oldFlow->template_Id ;
        $newFlow->status = "on";
        $newFlow->save();
        return $newFlow->flow_Id ;
    }
}
