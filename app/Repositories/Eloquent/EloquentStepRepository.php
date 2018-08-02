<?php

namespace App\Repositories\Eloquent;

use App\Models\Step;
use App\Repositories\Contracts\StepRepository;
use App\Repositories\Eloquent\EloquentFlowRepository as flowRepo;
use App\Repositories\Eloquent\EloquentValidatorRepository as validatorRepo;
use App\Repositories\Eloquent\EloquentPositionRepository as positionRepo;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentStepRepository extends AbstractRepository implements StepRepository
{
    public function entity()
    {
        return Step::class;
    }

    public static function addStep($title,$typeVerify,$typeValidator,$flow_Id,$validator,$deadline){
        $prev = Step::orderBy('step_Id','desc')->take(1)->get();
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
        if($flow_Id != ""){
            $allStepThisFlow = EloquentStepRepository::getStepByFlow($flow_Id);
            foreach($allStepThisFlow as $stepThisFlow){
                $allDeadline += $stepThisFlow['deadline'] ;
            }
            flowRepo::updateDeadline($flow_Id,$allDeadline);
        }
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
        foreach($allStepThisFlow as $stepFlow){
            $allDeadline += $stepFlow['deadline'] ;
        }
        flowRepo::updateDeadline($flow_Id,$allDeadline);
        return $step ;
    }

    public static function deleteStep($id){
        $step = Step::where('step_Id',$id)->first();
        $step->delete();
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

    public static function newStepVersion($oldStep,$newFlowId,$title,$typeVerify,$typeValidator,$validator,$deadline){
        $stepInThisFlow = EloquentStepRepository::getStepByFlow($oldStep['flow_Id']);
        // check is it new step in edit flow
        if($oldStep['step_Title'] == ""){
            array_push($stepInThisFlow,$oldStep);
            flowRepo::setNumOfStep($newFlowId,count($stepInThisFlow));
        }
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
        return $newObject ;
    }

    public static function changeStepVersion($oldStepObject,$newFlowId){
        $newStep = EloquentStepRepository::addStep($oldStepObject['step_Title'],$oldStepObject['typeOfVerify'],$oldStepObject['typeOfValidator'],$newFlowId,$oldStepObject['validator'],$oldStepObject['deadline']);
        $newStep->time_AVG = $oldStepObject['time_AVG'] ;
        $newStep->save();
        return ;
    }

    public static function removeValidator($stepId,$type){
        $step = Step::where('step_Id',$stepId)->first();
        $oldValidators = $step->validator ;
        if($step->typeOfValidator == "name"){
            foreach($oldValidators as $oldValidator){
                validatorRepo::removeStepFromValidator($oldValidator,$stepId);
            }
        } else if($step->typeOfValidator == "position"){
            positionRepo::removeStepFromPosition($oldValidators[0],$stepId);
        }
    }
}
