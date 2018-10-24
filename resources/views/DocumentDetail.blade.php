@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')   
    <div class="container content">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-sm-6 col-lg-6 d-none d-sm-block">
                <p class="topic">Document : {{$document['document_Name']}}</p>
            </div>
            {{-- <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <a role="button" class="btn btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div> --}}
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic">Document : {{$document['document_Name']}}</p>
            </div>
            {{-- <div class="col-12 d-sm-none">
                <a role="button" class="btn btn-block btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div> --}}
        </div> 
        <hr>
        @foreach($document['data'] as $detail)
            <span class='topic-nomal'>{{$detail['title']}} : </span> {{$detail['detail']}} <br>
        @endforeach

    </div>
@endsection