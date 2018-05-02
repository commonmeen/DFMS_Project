@extends('layout.Navbar')
@section('user')
    {{$data->user_Name}}
    {{$data->user_Surname}}
@endsection
@section('content')
    
    <div class="container content">
    <div class="row">
        <div class="col-lg-5 card mb-4">
            <img src="../pic/user.png" class="profilePic" >
            <div class="card-body">
                <div class="row">
                    <div class="col-ls-4 col-4">Name</div>
                    <div class="col-ls-8 col-8">{{$data->user_Name}}</div>
                </div>
                <div class="row">
                    <div class="col-ls-4 col-4">Surname</div>
                    <div class="col-ls-8 col-8">{{$data->user_Surname}}</div>
                </div>
                <div class="row">
                    <div class="col-ls-4 col-4">Position</div>
                    @foreach($data->user_Position as $position)
                        <div class="col-ls-8 col-8">{{$position}}</div>
                        @if(array_last($data->user_Position)!=$position)
                            <div class="col-ls-4 col-4"></div>
                        @endif
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-ls-4 col-4">Email</div>
                    <div class="col-ls-8 col-8">{{$data->user_Email}}</div>
                </div>                  
            </div>
        </div>
            <div class="col-lg-7">
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