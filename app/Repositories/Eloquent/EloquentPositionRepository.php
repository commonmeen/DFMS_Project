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
}
