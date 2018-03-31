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

    public function getFlowGroupCat(){
        $data = EloquentCategoryRepository::getAllCategory();
        log::info($data);
    }
}
