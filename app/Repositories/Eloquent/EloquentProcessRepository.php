<?php

namespace App\Repositories\Eloquent;

use App\Models\Process;
use App\Repositories\Contracts\ProcessRepository;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentProcessRepository extends AbstractRepository implements ProcessRepository
{
    public function entity()
    {
        return Process::class;
    }

    public static function getProcessById($process_Id){
        $data = Process::where('process_Id',$process_Id)->first();
        return json_decode($data,true);
    }

    public static function getProcessByOwner($user_Id){
        $data = Process::where('process_Owner',$user_Id)->get();
        return json_decode($data,true);
    }
}
