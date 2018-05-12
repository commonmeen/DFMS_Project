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
                <a role="button" class="btn btn-primary float-right" href="AddFlow">Create</a>
            </div>
        </div>
        <div class="row">
            @foreach($allFlow as $category =>$flow)
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <h5 class="card-header">{{$category}}</h5>
                <div class="card crad_detial mb-3">       
                    @foreach($flow as $flowdata)
                        <div class="list-group">
                            <a href="FlowDetail?id={{$flowdata['flow_Id']}}" class="list-group-item list-group-item-action">
                                @if($flowdata['status'] == "on")
                                    {{$flowdata['flow_Name']}}
                                @else
                                <img src="pic/lock.png" alt="lock" class="icon-lock">{{$flowdata['flow_Name']}}
                                @endif
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection