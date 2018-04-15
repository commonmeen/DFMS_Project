<?php

namespace App\Repositories\Eloquent;

use App\Step;
use App\Repositories\Contracts\StepRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentStepRepository extends AbstractRepository implements StepRepository
{
    public function entity()
    {
        return Step::class;
    }
}
