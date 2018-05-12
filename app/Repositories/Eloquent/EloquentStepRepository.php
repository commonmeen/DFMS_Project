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
        $step->timeAVG = 0 ;
        $step->save() ;
        return $newId ;
    }

    public static function getStepById($id)
    {
        $data = Step::where('step_Id',$id)->first();
        return json_decode($data);
    }

    public static function getStepByFlow($flowId){
        $data = Step::where('flow_Id',$flowId)->get();
        return json_decode($data);
    }
}
