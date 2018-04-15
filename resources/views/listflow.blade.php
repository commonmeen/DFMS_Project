@extends('layout.navbar') 
@section('content')   
    <div class="container content">
        <div class="row content">
            <div class="col-5"><h4>Flow list</h4></div>
            <div class="col-7 button-position">
                <a role="button" class="btn btn-primary " href="addFlow">Create</a>
            </div>
        </div>
        <div class="row">
            @foreach($allFlow as $category =>$flow)
            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <h5 class="card-header">{{$category}}</h5>
                <div class="card crad_detial">
                    <div class="card-body">        
                        @foreach($flow as $flowdata)
                            <ul>
                                <li>{{$flowdata['flow_Name']}}</li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
@endsection