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

    public static function getProcessByFlow($flow_Id){
        $data = Process::where('process_FlowId',$flow_Id)->orderBy('process_Id','desc')->get();
        return json_decode($data,true);
    }

    public static function changeStatusProcess($process_Id,$status){
        $process = Process::where('process_Id',$process_Id)->first();
        $process->current_StepId = $status ;
        $process->save();
    }

    public static function newProcess($owner,$flowId,$docId,$file,$txt,$docCode){
        $prev = Process::orderBy('process_Id','desc')->take(1)->get();
        $newId = 'P'.str_pad(substr($prev[0]->process_Id,1)+1, 5, '0', STR_PAD_LEFT);
        $step = EloquentStepRepository::getStepByFlow($flowId);
        $curStep = $step[0]['step_Id'] ;
        $process = new Process ;
        $process->process_Id = $newId ;
        $process->process_Owner = $owner ;
        $process->process_Time = 0 ;
        $process->current_StepId = $curStep ;
        $process->process_FlowId = $flowId ;
        $process->process_Step = [];
        $processData = app()->make('stdClass');
        $processData->document_Id = $docId ;
        $processData->docCode = $docCode ;
        $processData->file_Name = $file ;
        $processData->text = $txt ;
        $process->data = $processData ;
        $process->save();   
        return $process;
    }

    public static function approve($process_Id,$step_Id,$approver_Id,$comment,$docCode){
        $data = Process::where('process_Id',$process_Id)->first();
        $steps = EloquentStepRepository::getStepByFlow($data->process_FlowId);
        $nextStep;
        if($data->current_StepId == $step_Id){
            for($i = 0 ; $i<count($steps) ; $i++){
                if($steps[$i]['step_Id'] == $step_Id){
                    if(array_last($steps)!=$steps[$i]){
                        $nextStep = $steps[$i+1]['step_Id'] ;
                        $data->current_StepId = $nextStep ;
                    } else {
                        $data->current_StepId = "success" ;
                    }
                    break ;
                }
            }
            $approveData = app()->make('stdClass');
            $approveData->step_Id = $step_Id ;
            $approveData->validator_Id = $approver_Id ;
            $approveData->comment = $comment ;
            $approveData->doc_Code = $docCode ;
            $timeDiff = date_diff(now(),$data->updated_at) ;
            $stepTimeInMinute = $timeDiff->format('%d')*1440+$timeDiff->format('%h')*60+$timeDiff->format('%i') ;
            $approveData->step_Time = $stepTimeInMinute ;
            $data->process_Time = $data->process_Time+$stepTimeInMinute ;
            $approved = $data->process_Step ;
            array_push($approved,$approveData);
            $data->process_Step = $approved;
            $data->save();
            if( $data->current_StepId != "success"){
                return ['nextStep'=>$nextStep,'process'=>json_decode($data)];
            }
        }
        return false;
    }

    public static function reject($process_Id,$step_Id,$approver_Id,$comment){
        $data = Process::where('process_Id',$process_Id)->first();
        if($data->current_StepId == $step_Id){
            $data->current_StepId = "reject" ;
            $rejectData = app()->make('stdClass');
            $rejectData->step_Id = $step_Id ;
            $rejectData->validator_Id = $approver_Id ;
            $rejectData->comment = $comment ;
            $timeDiff = date_diff(now(),$data->updated_at) ;
            $stepTimeInMinute = $timeDiff->format('%d')*1440+$timeDiff->format('%h')*60+$timeDiff->format('%i') ;
            $rejectData->step_Time = $stepTimeInMinute ;
            $data->process_Time = $data->process_Time+$stepTimeInMinute ;
            $approved = $data->process_Step ;
            array_push($approved,$rejectData);
            $data->process_Step = $approved;
            $data->save();
        }
        return ;
    }
}
