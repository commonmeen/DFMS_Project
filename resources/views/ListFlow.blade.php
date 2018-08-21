@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')   
    <div class="container content">
        <div class="row content">
            <div class="col-5"><h4>Flow list</h4></div>
            <div class="col-7 ">
                <a role="button" class="btn add-btn float-right" href="AddFlow">Create</a>
            </div>
        </div>
        <div class="row">
            @foreach($allFlow as $category =>$flow) 
                @if($category == "อื่นๆ")
                @php $otherFlow = $flow @endphp
                @else
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <p class="card-header">{{$category}}</p>
                        <div class="card crad_detail mb-3">       
                            <div class="list-group">
                                @foreach($flow as $flowdata)
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
                @endif
            @endforeach
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <p class="card-header">อื่นๆ</p>
                <div class="card crad_detial mb-3">       
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
@endsection