<?php

namespace App\Repositories\Eloquent;

use App\Models\Step;
use App\Repositories\Contracts\StepRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentStepRepository extends AbstractRepository implements StepRepository
{
    public function entity()
    {
        return Step::class;
    }

    public static function addStep($title,$typeVerify,$typeValidator,$flow_Id,$validator,$deadline){
        $prev = Step::orderBy('created_at','desc')->take(1)->get();
        $newId = 'S'.str_pad(substr($prev[0]->step_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $step = new Step ;
        $step->step_Id = $newId ;
        $step->step_Title = $title ;
        $step->typeOfVerify = $typeVerify ;
        $step->typeOfValidator = $typeValidator;
        $step->flow_Id = $flow_Id ;
        $step->validator = $validator ;
        $step->deadline = $deadline ;
        $step->time_AVG = 0 ;
        $step->save() ;
        $allDeadline = 0;
        $allStepThisFlow = EloquentStepRepository::getStepByFlow($flow_Id);
        foreach($allStepThisFlow as $step){
            $allDeadline += $step['deadline'] ;
        }
        EloquentFlowRepository::updateDeadline($flow_Id,$allDeadline);
        return $step ;
    }

    public static function editStep($id,$title,$typeVerify,$typeValidator,$flow_Id,$validator,$deadline){
        $step = Step::where('step_Id',$id)->first();
        $step->step_Title = $title ;
        $step->typeOfVerify = $typeVerify ;
        $step->typeOfValidator = $typeValidator;
        $step->flow_Id = $flow_Id ;
        $step->validator = $validator ;
        $step->deadline = $deadline ;
        $step->time_AVG = 0 ;
        $step->save() ;
        $allDeadline = 0;
        $allStepThisFlow = EloquentStepRepository::getStepByFlow($flow_Id);
        foreach($allStepThisFlow as $step){
            $allDeadline += $step['deadline'] ;
        }
        EloquentFlowRepository::updateDeadline($flow_Id,$allDeadline);
        return $step ;
    }

    public static function getStepById($id)
    {
        $data = Step::where('step_Id',$id)->first();
        return json_decode($data,true);
    }

    public static function getStepByFlow($flowId){
        $data = Step::where('flow_Id',$flowId)->get();
        return json_decode($data,true);
    }

    public static function newStepVersion($oldStepId,$newFlowId,$title,$typeVerify,$typeValidator,$validator,$deadline){
        $oldStep = EloquentStepRepository::getStepById($oldStepId);
        $stepInThisFlow = EloquentStepRepository::getStepByFlow($oldStep['flow_Id']);
        foreach($stepInThisFlow as $step){
            if($step != $oldStep){
                $newObject = EloquentStepRepository::addStep($step['step_Title'],$step['typeOfVerify'],$step['typeOfValidator'],$newFlowId,$step['validator'],$step['deadline']);
                $newObject->time_AVG = $step['time_AVG'] ;
                $newObject->save();
            } else {
                $newObject = EloquentStepRepository::addStep($title,$typeVerify,$typeValidator,$newFlowId,$validator,$deadline);
                $newObject->time_AVG = $oldStep['time_AVG'] ;
                $newObject->save();
            }
        }
        return ;
    }
}
