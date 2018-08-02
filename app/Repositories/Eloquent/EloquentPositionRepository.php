<?php

namespace App\Repositories\Eloquent;

use App\Models\Position;
use App\Repositories\Contracts\PositionRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentPositionRepository extends AbstractRepository implements PositionRepository
{
    public function entity()
    {
        return Position::class;
    }

    public static function getAllPosition()
    {
        $data = Position::all();
        return json_decode($data);
    }

    public static function addStepToPosition($position_Id,$step){
        $position = Position::where('position_Id',$position_Id)->first();
        $array_step = $position->validate_Step ;
        array_push($array_step,$step);
        $position->validate_Step = $array_step ;
        $position->save();
        return ;
    }
    public static function removeStepFromPosition($position_Id,$step){
        $position = Position::where('position_Id',$position_Id)->first();
        $array_step = $position->validate_Step ;
        $key = array_search($step,$array_step);
        array_forget($array_step,$key);
        $position->validate_Step = $array_step ;
        $position->save();
        return ;
    }
}
