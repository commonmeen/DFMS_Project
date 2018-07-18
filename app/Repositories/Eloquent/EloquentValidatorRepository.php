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
}
