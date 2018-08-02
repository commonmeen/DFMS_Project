<?php

namespace App\Repositories\Eloquent;

use App\Models\Validator;
use App\Repositories\Contracts\ValidatorRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentValidatorRepository extends AbstractRepository implements ValidatorRepository
{
    public function entity()
    {
        return Validator::class;
    }

    public static function getValidateByUserId($user_Id){
        $validator = Validator::where('user_Id',$user_Id)->first();
        return json_decode($validator,true);
    }

    public static function addStepToValidator($user_Id,$step){
        $validator = Validator::where('user_Id',$user_Id)->first();
        if($validator == null){
            $validator = new Validator ;
            $validator->user_Id = $user_Id ;
            $validator->step_Id = [];
        }
        $array_step = $validator->step_Id ;
        array_push($array_step,$step);
        $validator->step_Id = $array_step ;
        $validator->save();
        return ;
    }
    public static function removeStepFromValidator($user_Id,$step){
        $validator = Validator::where('user_Id',$user_Id)->first();
        $array_step = $validator->step_Id ;
        $key = array_search($step,$array_step);
        array_forget($array_step,$key);
        $validator->step_Id = $array_step ;
        $validator->save();
        return ;
    }
}
