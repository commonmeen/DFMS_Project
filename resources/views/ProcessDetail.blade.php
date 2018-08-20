@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
{{--  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  --}}
<style>
    .bs-wizard {margin-top: 40px;}

    .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
    .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
    .bs-wizard > .bs-wizard-step + .bs-wizard-step {}
    .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 25px; margin-bottom: 5px; font-weight:bold}
    .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #595959; font-size: 25px;}
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 40px; height: 40px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -2px; margin-left: -15px; border-radius: 50%;} 
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 24px; height: 24px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
    .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
    .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
    .bs-wizard > .bs-wizard-step.active > .bs-wizard-dot:after {content: ' '; width: 24px; height: 24px; background: #f5f5f5; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
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
<script>
    function changeStatus(id){
        var data = {process_Id:id};
        $.ajax({
            type     : "GET",
            url      : "CancelProcess",
            data     : data,
            cache    : false,
            success  : function(response){
                window.location.reload();
            }
        });
    }
    function submit(processId,stepId,action){
        var data = {step_Id:stepId};
        document.getElementById("app-re1").innerHTML = action ;
        document.getElementById("app-re2").innerHTML = action ;
        document.getElementById("app-re3").innerHTML = action ;
        $.ajax({
            type     : "GET",
            url      : "CheckTypeValidate",
            data     : data,
            cache    : false,
            success  : function(response){
                if(response.type=="allow"){
                    $('#allowModal').modal();
                    $('#allowYes').click(function() {
                        sentAction(processId,stepId,action) ;
                        $('#allowModal').modal('hide');
                    });
                } else if (response.type == "password"){
                    $('#passwordModal').modal();
                    $('#passwordYes').click(function() {
                        // check password
                        sentAction(processId,stepId,action) ;
                        $('#passwordModal').modal('hide');
                    });
                } else if (response.type == "otp"){
                    $('#otpModal').modal();
                    $('#otpYes').click(function() {
                        // check otp
                        sentAction(processId,stepId,action) ;
                        $('#otpModal').modal('hide');
                    });
                }
            }
        });
    }
    function sentAction(processId,stepId,action){
        var ment = document.getElementById('comment').value ;
        if(action == "Reject" && ment==""){
            document.getElementById("comment").style.borderColor = "red" ;
            document.getElementById("errComment").innerHTML = "If you want to reject, you must give the reason by comment." ;
        } else {
            var data = {pid:processId,sid:stepId,comment:ment} ;
            $.ajax({
                type     : "GET",
                url      : action,
                data     : data,
                cache    : false,
                success  : function(response){
                    window.location = "ListVerify";
                }
            });
        }
    }
</script>
@section('content')
    <div class="container content">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-9 col-lg-9 d-none d-sm-block">
                <p class="topic">Process : {{$process['process_Name']}}</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 col-sm-9 d-sm-none">
                <p class="topic center">Process : {{$process['process_Name']}}</p>
            </div>

            @if($process['current_StepId']!="cancel"&&$process['current_StepId']!="success"&&$process['current_StepId']!="reject")
                @if(Session::get('UserLogin')->user_Id == $process['process_Owner'])
                    {{--  Large screen  --}}
                    <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                        <button class="btn btn-danger float-left" type="button" data-toggle="modal" data-target="#cancelProcessModalCenter">Cancel Process</button>
                    </div>
                    {{--  Small screen  --}}
                    <div class="col-12 d-sm-none">
                        <button class="btn btn-block btn-danger" type="button" data-toggle="modal" data-target="#cancelProcessModalCenter">Cancel Process</button>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="cancelProcessModalCenter" tabindex="-1" role="dialog" aria-labelledby="cancelProcessModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <p class="modal-title alert-title">
                                    Do you want to cancel "{{$process['process_Name']}}" process?
                                </p>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 form-group mb-0">
                                            <label class="col-form-labelr align-self-center">password</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" name="password" class="form-control">
                                        </div>
                                        <div class="col-lg-1"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$process['process_Id']}}')" data-dismiss="modal">Yes</button>   
                                </div>
                            </div>
                        </div>    
                    </div>
                @endif
            @else
                <div class="col-lg-3">
                    <p class="topic-cacel">( {{$process['current_StepId']}}ed )</p>
                </div>
            @endif
        </div>

        {{--  Progress Bar  --}}
        <div class="container">
            <div class="row bs-wizard " style="border-bottom:0;">
                @php $index = 1; $complete = count($process['process_Step'])  @endphp
                @foreach($steps as $step)
                    @if($index < $complete+1)
                        <div class="col-{{12/count($steps)}} col-md-{{12/count($steps)}} col-lg-{{12/count($steps)}} bs-wizard-step complete">                          
                    @elseif($index == $complete+1) 
                        <div class="col-{{12/count($steps)}} col-md-{{12/count($steps)}} col-lg-{{12/count($steps)}} bs-wizard-step active">
                    @else 
                        <div class="col-{{12/count($steps)}} col-md-{{12/count($steps)}} col-lg-{{12/count($steps)}} bs-wizard-step disabled"> 
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
        <br>
        <div class="row">
            <div class="col-lg-6 block-center">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label class="align-self-center mb-0 topic-nomal">Process Flow : </label>
                    </div>
                    <div class="col-12 col-lg-6">
                        {{$process['process_FlowName']}}
                    </div>
                </div>   
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <label class=" align-self-center mb-0 topic-nomal">Document in process : </label>
                    </div>
                    @foreach($process['data']['document_Name'] as $docName)
                        <div class="col-12 col-lg-6">{{$docName}}</div>
                        @if(array_last($process['data']['document_Name'])!=$docName)
                        @endif
                    @endforeach
                </div> 
                @if(count($process['data']['file_Name'])!=0)
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <label class="align-self-center mb-0 topic-nomal">File in process : </label>
                        </div>
                        @foreach($process['data']['file_Name'] as $fileName)
                            <div class="col-12 col-lg-6"><a target="_blank" href="upload/{{$fileName}}"> {{$fileName}} </a></div>
                            @if(array_last($process['data']['file_Name'])!=$fileName)
                            @endif
                        @endforeach
                    </div> 
                @endif
            </div>
        </div>
        <br>
        @if(count($process['process_Step'])!=0)
        <div class="row">
            <div class="col-lg-10 block-center mb-3">
                <p class="topic">Comments :</p>
                @foreach($process['process_Step'] as $stepApproved)
                    <div class="col-lg-12 bg-comment"><span class="usr-comment">{{$stepApproved['approver_Detail']['user_Name']}}  {{$stepApproved['approver_Detail']['user_Surname']}}</span>  : (Approved) {{$stepApproved['comment']}}</div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Approver Zone -->
        @if($canApprove)
            <div class="row">
                <div class="col-lg-12" style="text-align:center"><h4>Your comment :</h4></div> 
                <div class="col-12 col-sm-12 col-11 main-section">
                    <textarea class="col-8 block-center" name="comment" id="comment" rows="4" placeholder="input text here.."></textarea>
                    <div class="col-12"><p id="errComment"></p></div>  
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 text-center">
                        <button type="button" class="btn btn-danger m-2" onclick="submit('{{$process['process_Id']}}','{{$process['current_StepId']}}','Reject')">Reject</button>
                        <button type="button" class="btn btn-success m-2" onclick="submit('{{$process['process_Id']}}','{{$process['current_StepId']}}','Approve')">Approve</button>
                    </div>
                <div class="col-lg-2"></div>
            </div>  
        @endif
        <div class="modal fade" id="allowModal" tabindex="-1" role="dialog" aria-labelledby="allowModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-header">
                            <p class="modal-title alert-title">Are you sure to <span id="app-re1"></span> "{{$process['process_Name']}}" process? </p> 
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-secondary" id="allowYes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-header">
                            <p class="modal-title alert-title">Enter your password to <span id="app-re2"></span> "{{$process['process_Name']}}" process.</p> 
                        </div>    
                        <div class="row mb-3">
                            <div class="col-lg-3 form-group mb-0">
                                <label class="col-form-labelr align-self-center">password</label>
                            </div>
                            <div class="col-lg-8 mb-3">
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="col-lg-1"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-secondary" id="passwordYes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-header">
                            <p class="modal-title alert-title">
                                Please check SMS and enter OTP password to <span id="app-re3"></span> "{{$process['process_Name']}}" process.
                            </p>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 form-group">
                                    <label class="col-form-labelr align-self-center">OTP</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" name="password" class="form-control">
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-secondary" id="otpYes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
@endsection