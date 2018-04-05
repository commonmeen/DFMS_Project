@extends('layout.navbar')
@section('head')
    <link type="text/css" href="../css/manager_menu.css" rel="stylesheet">
@endsection 
@section('user')
    {{$data->user_Name}}
    {{$data->user_Surname}}
@endsection
@section('content')
    
    <div class="container content">
    <div class="row ">
        <div class="col-sm-4  center">
            <img src="../pic/user.png" class="profilePic">
        </div>
            <div class="col-sm-8">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="process-tab" data-toggle="tab" href="#process" role="tab" aria-controls="process" aria-selected="true">Process status</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" id="verify-tab" data-toggle="tab" href="#verify" role="tab" aria-controls="verify" aria-selected="false">Verify</a>
                    </li>
                </ul>
                
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                        <div class="card">
                            <div class="card-body">
                                <div class="row cardDetail">
                                    <div class="col-sm-3 col-md-3">Process name :</div>
                                    <div class="col-sm-5 col-md-5">ขอใช้สถานที่ CB2301</div>
                                    <div class="col-sm-3 col-md-3 currentStep"><button type="button " class="btn btn-primary" disabled>3/5</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                        <div class="tab-pane fade show active" id="process" role="tabpanel" aria-labelledby="process-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row cardDetail">
                                        <div class="col-sm-3 col-md-3">Process name :</div>
                                        <div class="col-sm-9 col-md-9">ขอใช้สถานที่ CB2301</div>
                                    </div>
                                    <div class="row cardDetail">
                                        <div class="col-sm-3 col-md-3">From :</div>
                                        <div class="col-sm-9 col-md-9">คณะเทคโนโลยีสารสนเทศ</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection