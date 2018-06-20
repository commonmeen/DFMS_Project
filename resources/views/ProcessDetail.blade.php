@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<style>
    .bs-wizard {margin-top: 40px;}

    .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
    .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
    .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
    .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 16px; margin-bottom: 5px;}
    .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #999; font-size: 14px;}
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 30px; height: 30px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -15px; margin-left: -15px; border-radius: 50%;} 
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
    .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
    .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
    .bs-wizard > .bs-wizard-step.active > .bs-wizard-dot:after {content: ' '; width: 14px; height: 14px; background: #f5f5f5; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
    .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
    .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
    .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
    .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #f5f5f5;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
    .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
    .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
    .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }
</style>
@section('content')
    <div class="container content">
        <div class="row">
            <div class="col-lg-9">
                <h3>Process : {{$process['process_Name']}}</h3>
            </div>
            <div class="col-lg-3">
                <a role="button" class="btn btn-danger float-right" href="">Cancel Process</a>
            </div>
        </div>

        {{-- Progress Bar --}}
        <div class="container">
            <div class="row bs-wizard" style="border-bottom:0;">
                @php $index = 1; $complete = count($process['process_Step'])  @endphp
                @foreach($steps as $step)
                    @if($index < $complete)
                        <div class="col-xs-{{12/count($steps)}} bs-wizard-step complete">                             
                    @elseif($index == $complete) 
                        <div class="col-xs-{{12/count($steps)}} bs-wizard-step active">
                    @else 
                        <div class="col-xs-{{12/count($steps)}} bs-wizard-step disabled"> 
                    @endif          
                            <div class="text-center bs-wizard-stepnum">Step {{$index++}}</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">{{$step['step_Title']}}</div>
                        </div>
                @endforeach
            </div>  
        </div>
        {{-- End Progress Bar --}}

        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="row mb-5"></div>
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label class="col-form-labelr align-self-center">Process Flow : </label>
                    </div>
                    <div class="col-lg-8 mb-3">
                        {{$process['process_FlowName']}}
                    </div>
                </div>   
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <label class="col-form-labelr align-self-center">Document in process : </label>
                    </div>
                    @foreach($process['data']['document_Name'] as $docName)
                        <div class="col-lg-8 mb-3">{{$docName}}</div>
                        @if(array_last($process['data']['document_Name'])!=$docName)
                        <div class="col-lg-4"></div>
                        @endif
                    @endforeach
                </div> 
                @if(count($process['data']['file_Name'])!=0)
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label class="col-form-labelr align-self-center">File in process : </label>
                        </div>
                        @foreach($process['data']['file_Name'] as $fileName)
                            <div class="col-lg-8 mb-3">{{$fileName}}</div>
                            @if(array_last($process['data']['file_Name'])!=$fileName)
                            <div class="col-lg-4"></div>
                            @endif
                        @endforeach
                    </div> 
                @endif
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
@endsection