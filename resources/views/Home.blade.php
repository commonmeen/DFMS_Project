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

                {{--  Tabs  --}}
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active toggle-nav" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="true">Process status</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link toggle-nav" id="verify-tab" data-toggle="tab" href="#verify" role="tab" aria-controls="verify" aria-selected="false">Verify</a>
                    </li>
                </ul>
                {{--  Process tab  --}}
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                        @foreach($allProcess as $process)
                            <div class="card">
                                <a href="ProcessDetail?id={{$process['process_Id']}}" class="list-group-item-action">
                                    <div class="card-body">
                                        @php $step = count($process['process_Step'])@endphp
                                        <div class="row cardDetail">
                                            <span class="col-10">Process name : {{$process['process_Name']}}</span>
                                            <button type="button" class="btn step-btn col-2" disabled>{{$step}}/{{$process['numberOfStep']}}</button>
                                        </div>   
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                {{--  Verify Process  --}}
                    <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                        <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                            @foreach($nowProcess as $process)
                                <div class="card">
                                    <a href="ProcessDetail?id={{$process['process_Id']}}&InProgress=true" class="list-group-item-action">
                                        <div class="card-body">
                                            <div class="row cardDetail">
                                                <span class="col-10">Process name : {{$process['process_Name']}} </span>
                                            </div>
                                            <div class="row cardDetail">
                                                <span class="col-10">Flow name : {{$process['flowObject']['flow_Name']}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6 col-md-6 mt-3">
                <div class="row">
                    {{--  Large screen  --}}
                    <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-md-block">   
                        <p class="topic">Flow Template</p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 d-none d-md-block">
                        <a role="button" class="btn btn-success float-right" href="AddFlow">Add Flow</a>
                    </div>

                     {{--  Small screen  --}}
                    <div class="col-12 d-md-none center mt-3">   
                        <p class="topic">Flow</p>
                    </div>
                    <div class="col-12 d-md-none ">
                        <a role="button" class="btn btn-block btn-success float-right" href="AddFlow">Add Flow</a>
                    </div>
                </div>
                <div class="card">                  
                    <div class="card-body card-cat">
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
                        <a class="nav-link active toggle-nav" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="true">Process status</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link toggle-nav" id="verify-tab" data-toggle="tab" href="#verify" role="tab" aria-controls="verify" aria-selected="false">Verify</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row cardDetail">
                                    <span class="col-10">Process name : ขอใช้สถานที่ CB2301</span>
                                    <button type="button" class="btn step-btn col-2">3/5</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                        <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row cardDetail">
                                        <span class="col-10">Process name : ขอใช้สถานที่ CB2301 </span>
                                    </div>
                                    <div class="row cardDetail">
                                        <span class="col-10">From : คณะเทคโนโลยีสารสนเทศ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    
@endsection