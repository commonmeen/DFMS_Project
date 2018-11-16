@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')
    {{-- Manager Role --}}
    @if(Session::get('UserLogin')->user_Role == 'manager')
    <div class="container content">
        <div class="row">
            <div class="col-12 col-lg-6 col-md-6 mt-3">
                <div class="mb-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="../pic/user.png" class="profilePic" > 
                        </div>
                        <div class="col-lg-8">
                            <span><span class="topic-nomal">Name : </span>{{$data->user_Name}} {{$data->user_Surname}}</span><br>
                            <span class="topic-nomal">Position : </span>   
                                @foreach($data->user_Position as $position)
                                    {{$position}}
                                    @if(array_last($data->user_Position)!=$position)
                                        ,
                                    @endif
                                @endforeach
                            <br><span><span class="topic-nomal">Email : </span>{{$data->user_Email}}</span>
                        </div>
                    </div>    
                </div>

                {{--  Tabs  --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active toggle-nav" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="true">
                            Process status 
                            @if(count($allProcess) >=100)
                            <span class="count">
                                99+
                            </span>
                            @else 
                            <span class="count">
                                {{count($allProcess)}}
                            </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link toggle-nav" id="verify-tab" data-toggle="tab" href="#verify" role="tab" aria-controls="verify" aria-selected="false">
                            Approve status 
                            @if(count($nowProcess) >=100)
                                <span class="count">
                                    99+
                                </span>
                                @else 
                                <span class="count">
                                    {{count($nowProcess)}}
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
                {{--  Process tab  --}}
                <div class="tab-content process-height" id="myTabContent">
                    <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                        @if(count($allProcess)==0)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row cardDetail">
                                        <span class="text-center col-12 overflow-text topic-nomal">Don't have any process.</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($allProcess as $process)
                                @if($process['current_StepId']!="success" && $process['current_StepId']!="cancel" && $process['current_StepId']!="reject")
                                    <div class="card">
                                        <a href="ProcessDetail?id={{$process['process_Id']}}" class="list-group-item-action">
                                            <div class="card-body">
                                                @php $step = count($process['process_Step'])@endphp
                                                <div class="row cardDetail">
                                                    <span class="col-12 overflow-text"><span class="topic-nomal">Flow name : </span>{{$process['flow_Name']}}</span>
                                                    <span class="col-12"><span class="topic-nomal">Stage : 
                                                            @if($step==0)
                                                                </span>N/A</span>
                                                            @else
                                                                </span>{{$step}} of {{$process['numberOfStep']}}</span>
                                                            @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                {{--  Approve Process  --}}
                    <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                        <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                            @if(count($nowProcess)==0)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row cardDetail">
                                            <span class="text-center col-12 overflow-text topic-nomal">Don't have any process.</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach($nowProcess as $process)
                                    <div class="card">
                                        <a href="ProcessDetail?id={{$process['process_Id']}}" class="list-group-item-action">
                                            <div class="card-body">
                                                <div class="row cardDetail">
                                                    <span class="col-10 overflow-text"><span class="topic-nomal">Process owner : </span>{{$process['owner']}}</span>
                                                </div>
                                                <div class="row cardDetail">
                                                    <span class="col-10 overflow-text"><span class="topic-nomal">Flow name : </span>{{$process['flowObject']['flow_Name']}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-6 mt-3">
                <div class="row">
                    {{--  Large screen  --}}
                    <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-md-block">   
                        <p class="topic">Process Flow</p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 d-none d-md-block">
                        <a role="button" class="btn btn-success float-right" href="AddFlow">Create Process Flow</a>
                    </div>

                     {{--  Small screen  --}}
                    <div class="col-12 d-md-none center mt-3">   
                        <p class="topic">Process Flow</p>
                    </div>
                    <div class="col-12 d-md-none ">
                        <a role="button" class="btn btn-block btn-success float-right" href="AddFlow">Create Process Flow</a>
                    </div>
                </div>
                <div class="card card-cat">                  
                    <div class="card-body ">
                        @foreach($catFlow as $category =>$flow)               
                        @if($category == "อื่นๆ")
                            @php $otherFlow = $flow @endphp
                        @else
                            <button class="btn step-btn" style="width:100%" type="button" data-toggle="collapse" data-target="#{{$category}}" aria-expanded="false" aria-controls="{{$category}}">{{$category}} <i class="dropdown-btn fas fa-caret-down"></i></button><br>                    
                            <div class="collapse" id="{{$category}}">       
                                <div class="list-group" >
                                    <div class="mb-2">
                                    @foreach($flow as $flowdata)
                                        @if($flowdata['status'] == "on" || $flowdata['status'] == "off")
                                        <a href="FlowDetail?id={{$flowdata['flow_Id']}}" class="list-group-item list-group-item-action" >
                                            @if($flowdata['status'] == "on")
                                                {{$flowdata['flow_Name']}}
                                            @else
                                            <img src="pic/lock.png" alt="lock" class="icon-lock">{{$flowdata['flow_Name']}}
                                            @endif
                                        </a>
                                        @endif    
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    
                        <button class="btn step-btn" style="width:100%" type="button" data-toggle="collapse" data-target="#others" aria-expanded="false" aria-controls="{{$category}}">อื่นๆ<i class="dropdown-btn fas fa-caret-down"></i></button><br>
                        <div class="collapse" id="others">      
                            <div class="list-group">
                                @foreach($otherFlow as $flowdata)
                                    @if($flowdata['status'] == "on" || $flowdata['status'] == "off")
                                    <a href="FlowDetail?id={{$flowdata['flow_Id']}}" class="list-group-item list-group-item-action">
                                        @if($flowdata['status'] == "on")
                                            {{$flowdata['flow_Name']}}
                                        @else
                                        <img src="pic/lock.png" alt="lock" class="icon-lock">{{$flowdata['flow_Name']}}
                                        @endif
                                    </a>
                                    @endif    
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- User Role --}}
    @else
    <div class="container content">
        <div class="row">
            <div class="col-12 col-lg-4 col-md-6 mt-3">
                <div class="row">
                    <div class="col-lg-12 center mb-3">
                        <img src="../pic/user.png" class="profilePic" style="width:30%"> 
                    </div>
                    <div class="col-lg-12">
                        <span>Name : {{$data->user_Name}} {{$data->user_Surname}}</span><br>
                        <span>Position : </span>   
                            @foreach($data->user_Position as $position)
                                {{$position}}
                                @if(array_last($data->user_Position)!=$position)
                                    ,
                                @endif
                            @endforeach
                        <br><span>Email : {{$data->user_Email}}</span>
                    </div>
                </div>    
            </div>
            
            <div class="col-12 col-md-6 col-lg-8 mt-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active toggle-nav" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="true">
                            Process status 
                            @if(count($allProcess) >=100)
                            <span class="count">
                                99+
                            </span>
                            @else
                            <span class="count">
                                {{count($allProcess)}}
                            </span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link toggle-nav" id="verify-tab" data-toggle="tab" href="#verify" role="tab" aria-controls="verify" aria-selected="false">
                        Approve
                            @if(count($nowProcess) >=100)
                            <span class="count">
                                99+
                            </span>
                            @else
                            <span class="count">
                                {{count($nowProcess)}}
                            </span>
                            @endif
                    </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                        @if(count($allProcess)==0)
                            <div class="card">
                                <div class="card-body">
                                    <div class="row cardDetail">
                                        <span class="text-center col-12 overflow-text topic-nomal">Don't have any process.</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($allProcess as $process)
                                @if($process['current_StepId']!="success" && $process['current_StepId']!="cancel" && $process['current_StepId']!="reject")
                                    <div class="card">
                                        <a href="ProcessDetail?id={{$process['process_Id']}}" class="list-group-item-action">
                                            <div class="card-body">
                                                @php $step = count($process['process_Step'])@endphp
                                                <div class="row cardDetail">
                                                    <span class="col-12"><span class="topic-nomal">Flow name : </span>{{$process['flow_Name']}}</span>
                                                    <span class="col-12"><span class="topic-nomal">Stage : 
                                                        @if($step==0)
                                                            </span>N/A</span>
                                                        @else
                                                            </span>{{$step}} of {{$process['numberOfStep']}}</span>
                                                        @endif
                                                </div>   
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                        <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                            @if(count($nowProcess)==0)
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row cardDetail">
                                            <span class="text-center col-12 overflow-text topic-nomal">Don't have any process.</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                @foreach($nowProcess as $process)
                                    <div class="card">
                                        <a href="ProcessDetail?id={{$process['process_Id']}}" class="list-group-item-action">
                                            <div class="card-body">
                                                <div class="row cardDetail">
                                                    <span class="col-10 overflow-text"><span class="topic-nomal">Process owner : </span>{{$process['owner']}}</span>
                                                </div>
                                                <div class="row cardDetail">
                                                    <span class="col-10 overflow-text"><span class="topic-nomal">Flow name : </span>{{$process['flowObject']['flow_Name']}}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    
@endsection