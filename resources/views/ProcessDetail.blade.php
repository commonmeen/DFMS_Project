@extends('layout.Navbar') 
@section('script')
    <link rel="stylesheet" href="css/cloudflare-animate.min.css">
    <link rel="stylesheet" href="css/jsdelivr-animate.min.css">
@endsection
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
{{--  <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">  --}}
<style>
    .bs-wizard {margin-top: 40px;}
    .bs-wizard {border-bottom: solid 1px #e0e0e0; padding: 0 0 10px 0;}
    .bs-wizard > .bs-wizard-step {padding: 0; position: relative;}
    .bs-wizard > .bs-wizard-step + .bs-wizard-step { width: 11%}
    .bs-wizard > .bs-wizard-step .bs-wizard-stepnum {color: #595959; font-size: 25px; margin-bottom: 5px; font-weight:bold}
    .bs-wizard > .bs-wizard-step .bs-wizard-info {color: #595959; font-size: 20px; width:100%}
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot {position: absolute; width: 40px; height: 40px; display: block; background: #fbe8aa; top: 45px; left: 50%; margin-top: -2px; margin-left: -19px; border-radius: 50%;} 
    .bs-wizard > .bs-wizard-step > .bs-wizard-dot:after {content: ' '; width: 24px; height: 24px; background: #fbbd19; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
    .bs-wizard > .bs-wizard-step > .progress {position: relative; border-radius: 0px; height: 8px; box-shadow: none; margin: 20px 0;}
    .bs-wizard > .bs-wizard-step > .progress > .progress-bar {width:0px; box-shadow: none; background: #fbe8aa;}
    .bs-wizard > .bs-wizard-step.active > .bs-wizard-dot:after {content: ' '; width: 24px; height: 24px; background: #f5f5f5; border-radius: 50px; position: absolute; top: 8px; left: 8px; } 
    .bs-wizard > .bs-wizard-step.complete > .progress > .progress-bar {width:100%;}
    .bs-wizard > .bs-wizard-step.active > .progress > .progress-bar {width:50%;}
    .bs-wizard > .bs-wizard-step:first-child.active > .progress > .progress-bar {width:0%;}
    .bs-wizard > .bs-wizard-step:last-child.active > .progress > .progress-bar {width: 100%;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot {background-color: #e9ecef;}
    .bs-wizard > .bs-wizard-step.disabled > .bs-wizard-dot:after {opacity: 0;}
    .bs-wizard > .bs-wizard-step:first-child  > .progress {left: 50%; width: 50%;}
    .bs-wizard > .bs-wizard-step:last-child  > .progress {width: 50%;}
    .bs-wizard > .bs-wizard-step.disabled a.bs-wizard-dot{ pointer-events: none; }   
</style>
<script>

    function checkPassword(id){
        var password = document.getElementById('cancelPassword').value;
        var pass = {password:password};
        var data = {process_Id:id};
        $.ajax({
            type     : "GET",
            url      : "ChkPassword",
            data     : pass,
            cache    : false,
            success  : function(response){
                if(response.status==false){
                    document.getElementById('errCancelPassword').innerHTML = "Incorrect password please try again";
                }else{
                    $.ajax({
                        type     : "GET",
                        url      : "CancelProcess",
                        data     : data,
                        cache    : false,
                        success  : function(response){
                            window.location.reload();
                        }
                    });
                    $('#cancelProcessModalCenter').modal('hide');
                }
            }
        });
    }

    function submit(processId,stepId,action){
        var data = {step_Id:stepId};
        document.getElementById("app-re1").innerHTML = action ;
        document.getElementById("app-re2").innerHTML = action ;
        document.getElementById("app-re3").innerHTML = action ;
        var ment = document.getElementById('comment').value ;
        if(action == "Reject" && ment==""){
            document.getElementById("comment").style.borderColor = "red" ;
            document.getElementById("errComment").innerHTML = "If you want to reject, you must give the reason by comment." ;
        } else {
            $.ajax({
                type     : "GET",
                url      : "CheckTypeValidate",
                data     : data,
                cache    : false,
                success  : function(response){
                    if(response.type=="allow"){
                        $('#allowModal').modal();
                        $('#allowYes').click(function() {

                            //Start loading
                            $(document).ajaxStart(function(){
                                $("#wait").css("display", "block");
                                $('body').css('position','relative');
                                $('body').css('min-height','100%');
                                $('#overlay').css("display","block");
                            });
                            
                            sentAction(processId,stepId,action) ;
                            $('#allowModal').modal('hide');
                        });
                    } else if (response.type == "password"){
                        $('#passwordModal').modal();
                        $('#passwordYes').click(function() {
                            
                            //Start loading
                            $(document).ajaxStart(function(){
                                $("#wait").css("display", "block");
                                $('body').css('position','relative');
                                $('body').css('min-height','100%');
                                $('#overlay').css("display","block");
                            });

                            var data = {password:document.getElementById('password').value} ;
                            var statusAlready = $.Deferred();
                            var status ;
                            $.ajax({
                                type     : "GET",
                                url      : "ChkPassword",
                                data     : data,
                                cache    : false,
                                success  : function(response){
                                    status = response.status;
                                    statusAlready.resolve(status) ;
                                }
                            });
                            statusAlready.done(function() {
                                if(status){
                                    sentAction(processId,stepId,action) ;
                                    $('#passwordModal').modal('hide');
                                } else {
                                    document.getElementById('incorrectPass').innerHTML = "Incorrect Password, Please try again." ;
                                }
                            });
                        });
                    } else if (response.type == "otp"){
                        sentSMS();
                        $('#otpModal').modal();
                        $('#otpYes').click(function() {

                            document.getElementById('incorrectOTP').innerHTML = "";
                            var data = {otp:document.getElementById('otp').value} ;
                            var statusAlready = $.Deferred();
                            var status ;
                            $.ajax({
                                type     : "GET",
                                url      : "ChkOTP",
                                data     : data,
                                cache    : false,
                                success  : function(response){
                                    status = response.status;
                                    statusAlready.resolve(status) ;
                                }
                            });
                            statusAlready.done(function() {
                                if(status){
                                    sentAction(processId,stepId,action) ;
                                    $('#otpModal').modal('hide');

                                    //Start loading
                                    $(document).ajaxStart(function(){
                                        $("#wait").css("display", "block");
                                        $('body').css('position','relative');
                                        $('body').css('min-height','100%');
                                        $('#overlay').css("display","block");
                                    });
                                } else {
                                    document.getElementById('incorrectOTP').innerHTML = "Incorrect OTP, Please try again" ;
                                }
                            });
                        });
                    }
                }
            });
        }
    }
    function sentAction(processId,stepId,action){
        var ment = document.getElementById('comment').value ;
        var data = {pid:processId,sid:stepId,comment:ment} ;
        $.ajax({
            type     : "GET",
            url      : action,
            data     : data,
            cache    : false,
            success  : function(response){

                $(document).ajaxComplete(function(){
                    $("#wait").css("display", "block");
                    $('body').css('position','relative');
                    $('body').css('min-height','100%');
                    $('#overlay').css("display","block");
                });
                window.location = "ListVerify";
            }
        });
    }
    function sentSMS(){
        $.ajax({
            type     : "GET",
            url      : "SentOTP",
            data     : {},
            cache    : false,
            success  : function(response){
                console.log("OTP is sented");
            }
        });
    }

    function showDocument(docName){
        document.getElementById('show').innerHTML = "";
        @foreach($document as $doc)
            var documentName = '<?= $doc['document_Name'] ?>';
            
            if(docName == documentName){
                document.getElementById('show').innerHTML += "<h5 class=center style='margin-bottom:0px'>"+documentName+"</h5><br>";
                @foreach($doc['data'] as $detail)
                    var title = '<?= $detail['title'] ?>';
                    var detail = '<?= $detail['detail'] ?>';
                    document.getElementById('block-document').hidden = false;
                    document.getElementById('show').hidden = false;
                    document.getElementById('show').innerHTML += "<span class='topic-nomal'>"+title+"</span> : "; 
                    document.getElementById('show').innerHTML += detail+"<br>";
                @endforeach
            }
        @endforeach
    }
</script>
@section('content')
<div id="overlay" style="display:none"></div>
    <div class="container content">

        {{--  Success alert  --}}
        @if(Session::get("alertStatus") == "CancelSuccess")
            <div class="alert alert-success" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Cancel Success! </strong>
                You have successfully cancel the process.
            </div>
    
            <script>
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
            </script>
            {{Session::forget("alertStatus")}}
        @endif
        

        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-9 col-lg-9 d-none d-sm-block">
                <p class="topic">Process : {{$process['process_FlowName']}}</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 col-sm-9 d-sm-none">
                <p class="topic center ">Process : {{$process['process_FlowName']}}</p>
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

                    {{--  Cancel Process  --}}
                    <!-- Modal -->
                    <div class="modal fade" id="cancelProcessModalCenter" tabindex="-1" role="dialog" aria-labelledby="cancelProcessModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <p class="modal-title alert-title">
                                    Do you want to cancel "{{$process['process_FlowName']}}" process?
                                </p>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-3 form-group mb-0">
                                            <label class="col-form-labelr align-self-center">Password</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="password" name="password" id="cancelPassword" class="form-control">
                                        </div>
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-9">
                                            <div id="errCancelPassword" class="err-text"></div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$process['process_Id']}}')">Yes</button>   
                                </div>
                            </div>
                        </div>    
                    </div>
                @endif
            @else
                <div class="col-lg-3">
                    <p class="topic-cacel">( {{ucwords($process['current_StepId'])}}ed )</p>
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
                            @if(count($steps)==1)
                                <a href="#" class="bs-wizard-dot" style="margin-buttom:5px"></a>
                                <div class="bs-wizard-info text-center mt-4">{{$step['step_Title']}}</div>
                            @else
                                <div class="progress"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center">{{$step['step_Title']}}</div>
                            @endif
                        </div>
                @endforeach
            </div>  
        </div>
        {{-- End Progress Bar --}}
        <br>
        <div class="row">
            <div class="col-lg-6 block-center" id="block-data">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <label class="align-self-center mb-0 topic-nomal">Process owner : </label>
                    </div>
                    <div class="col-12 col-lg-7">
                        {{$owner->user_Name}}  {{$owner->user_Surname}}
                    </div>
                </div>  
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <label class=" align-self-center mb-0 topic-nomal">Document in process : </label>
                    </div>
                    @foreach($process['data']['document_Name'] as $docName)
                        <button class="btn btn-outline-primary col-lg-7 col-12 overflow-text"  onclick="showDocument('{{$docName}}')">{{$docName}}</button> 
                        <div class="col-lg-5"></div>
                    @endforeach
                </div> 
                @if(count($process['data']['file_Name'])!=0)
                    <div class="row">
                        <div class="col-12 col-lg-5">
                            <label class="align-self-center mb-0 topic-nomal">File in process : </label>
                        </div>
                        @foreach($process['data']['file_Name'] as $fileName)
                            <div class="col-12 col-lg-7"><a target="_blank" href="upload/{{$fileName}}"> {{$fileName}} </a></div>
                            @if(array_last($process['data']['file_Name'])!=$fileName)
                                <div class="col-12 col-lg-5"></div>
                            @endif
                        @endforeach
                    </div> 
                @endif
            </div>                        
            <div class="col-lg-8 block-center animated fadeInUp delay-3s" sytle="overflow:hidden" id="block-document" hidden>
                <div id="show" class="doc-block" hidden></div>
            </div>        
        </div>
        <br>
        @if(count($process['process_Step'])!=0)
            <div class="row">
                <div class="col-lg-6 block-center mb-3">
                    <p class="topic">Comments :</p>
                    @foreach($process['process_Step'] as $stepApproved)
                        @if($process['current_StepId']=="reject")
                            <div class="col-lg-12 bg-comment"><span class="usr-comment">{{$stepApproved['approver_Detail']['user_Name']}}  {{$stepApproved['approver_Detail']['user_Surname']}}</span>  : (Rejected) {{$stepApproved['comment']}}</div>
                        @else
                            <div class="col-lg-12 bg-comment"><span class="usr-comment">{{$stepApproved['approver_Detail']['user_Name']}}  {{$stepApproved['approver_Detail']['user_Surname']}}</span>  : (Approved) {{$stepApproved['comment']}}</div>
                        @endif    
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
                    <div id="errComment" class="block-center col-lg-8 err-text"></div>
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
        <!-- Modal -->
        <div class="modal fade" id="allowModal" tabindex="-1" role="dialog" aria-labelledby="allowModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="modal-header">
                            <p class="modal-title alert-title">Are you sure to <span id="app-re1"></span> "{{$process['process_FlowName']}}" process? </p> 
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
                            <p class="modal-title alert-title">Enter your password to <span id="app-re2"></span> "{{$process['process_FlowName']}}" process.</p> 
                        </div>    
                        <div class="row mt-3">
                            <div class="col-lg-3 form-group mb-0">
                                <label class="col-form-labelr align-self-center">Password</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                           
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group mb-0"></div>
                            <div class="col-lg-8">
                                <p style="color:red" id="incorrectPass" class="err-text"></p>
                            </div>
                            
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
                                Please check your email and enter OTP code to <span id="app-re3"></span> "{{$process['process_FlowName']}}" process.
                            </p>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label class="col-form-labelr align-self-center">OTP</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" id="otp" name="otp" class="form-control">
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8">
                                    <p style="color:red" id="incorrectOTP" class="err-text"></p>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <div class="modal-footer">            
                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-success" id="otpYes">Yes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
    
        <div id="wait" style="display:none">
            <div class="loader"></div>
            <p class="center loading">Loading..</p>
        </div>
    
    
    <style>
        #wait{
            position:fixed;
            top:50%;
            left:50%;
            padding:2px;
            z-index: 20;
            color: #FFF;
            transform: translate(-50%, -50%);
        }

        #overlay{
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100vw;
            z-index: 10;
            background-color: rgba(0,0,0,0.5); /*dim the background*/
            
          }
          html{
              min-height: 100%;
          }
          .loading{
              font-size: 24pt;
          }
          .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #2A9EBF;
            border-bottom: 16px solid #2A9EBF;
            width: 90px;
            height: 90px;
            -webkit-animation: spin 0.7s linear infinite;
            animation: spin 0.7s linear infinite;
          }
          @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
          }
          
          @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
          }
    </style>
@endsection