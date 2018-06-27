<?php

namespace App\Repositories\Eloquent;

use App\Models\Process;
use App\Repositories\Contracts\ProcessRepository;
use App\Repositories\Eloquent\EloquentStepRepository;

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

    public static function changeStatusProcess($process_Id,$status){
        $process = Process::where('process_Id',$process_Id)->first();
        $process->current_StepId = $status ;
        $process->save();
    }

    public static function newProcess($name,$owner,$flowId,$docId,$file,$txt){
        $prev = Process::orderBy('created_at','desc')->take(1)->get();
        $newId = 'P'.str_pad(substr($prev[0]->process_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $step = EloquentStepRepository::getStepByFlow($flowId);
        $curStep = $step[0]['step_Id'] ;
        $process = new Process ;
        $process->process_Id = $newId ;
        $process->process_Name = $name ;
        $process->process_Owner = $owner ;
        $process->process_Time = 0 ;
        $process->current_StepId = $curStep ;
        $process->process_FlowId = $flowId ;
        $process->process_Step = [];
        $processData = app()->make('stdClass');
        $processData->document_Id = $docId ;
        $processData->file_Name = $file ;
        $processData->text = $txt ;
        $process->data = $processData ;
        $process->save();   
        return $process;
    }
}
