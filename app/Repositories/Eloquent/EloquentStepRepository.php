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

    public static function getStepById($id)
    {
        $data = Step::where('step_Id',$id)->first();
        return json_decode($data);
    }
}
