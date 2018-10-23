@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
<script type="text/javascript">
    function checkPassword(id,status){
        var password = document.getElementById('password').value;
        var data = {password:password};
        $.ajax({
            type     : "GET",
            url      : "ChkPassword",
            data     : data,
            cache    : false,
            success  : function(response){
                console.log(response.status);
                if(response.status==false){
                    document.getElementById('errPassword').innerHTML = "Incorrect password please try again";
                }else{
                    changeStatus(id,status);
                    $('#lockFlowModalCenter').modal('hide');
                }
            }
        });
    }

    function changeStatus(id,status){
        var data = {flow_id:id,newStatus:status};
        $.ajax({
            type     : "GET",
            url      : "LockFlow",
            data     : data,
            cache    : false,
            success  : function(response){
                window.location.reload();
            }
        });
    }
</script>
@section('content')   
    <div class="container content">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-sm-6 col-lg-6 d-none d-sm-block">
                <p class="topic">Flow : {{$flow['flow_Name']}}</p>
            </div>
            <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <a role="button" class="btn btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic">Flow : {{$flow['flow_Name']}}</p>
            </div>
            <div class="col-12 d-sm-none">
                <a role="button" class="btn btn-block btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div>

                @if($flow['status']=="on")
                    {{--  Large screen  --}}
                    <div class="col-sm-3 col-md-3 col-lg-3 d-none d-sm-block">
                        <button class="btn red-button float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Lock</button>
                    </div>
                    {{--  Small screen  --}}
                    <div class="col-12 center d-sm-none">
                        <button class="btn btn-block red-button float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Lock</button>
                    </div>
                @elseif($flow['status']=="off")
                    {{--  Large screen  --}}
                    <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                        <button class="btn red-button float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Unlock</button>
                    </div>
                    {{--  Small screen  --}}
                    <div class="col-12 d-sm-none">
                        <button class="btn btn-block red-button" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Unlock</button>
                    </div>
                @endif
                <!-- Modal -->
                <div class="modal fade" id="lockFlowModalCenter" tabindex="-1" role="dialog" aria-labelledby="lockFlowModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            @if($flow['status']=="on")
                                <div class="modal-header alert-title">
                                    Do you want to lock "{{$flow['flow_Name']}}" ?
                                </div>
                            @elseif($flow['status']=="off")
                                <div class="modal-header alert-title">
                                    "{{$flow['flow_Name']}}" is locked. Do you want to unlock "{{$flow['flow_Name']}}"?
                                </div>
                            @endif
                            <div class="modal-body row">
                                <div class="col-lg-3 form-group mb-0 horizon-center">
                                    <label class="col-form-labelr ">Password</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9">
                                    <div id="errPassword" class="err-text"></div> 
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                @if($flow['status']=="on")
                                    <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$flow['flow_Id']}}','off')">Yes</button>
                                @elseif($flow['status']=="off") 
                                    <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$flow['flow_Id']}}','on')">Yes</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>  
        </div>
        <div class="row">
            <div class="col-lg-10 block-center mt-3 mb-3">
                <div class="row">
                    <div class="col-lg-2">
                        <label class="col-form-labelr align-self-center topic-nomal mb-0">Description : </label>
                    </div>
                    <div class="col-lg-9" style="white-space:pre-line;">
                        {{$flow['flow_Description']}}
                    </div>
                </div>   
                <div class="row">
                    <div class="col-lg-2">
                        <label class="col-form-labelr align-self-center topic-nomal mb-0">Deadline : </label>
                    </div>
                    <div class="col-lg-9">
                        {{$flow['flow_Deadline']}} Day(s)
                    </div>
                </div> 
                <div class="row">
                    <div class="col-lg-2">
                        <label class="col-form-labelr align-self-center topic-nomal mb-0">Category : </label>
                    </div>
                    <div class="col-lg-9">
                        {{$flow['flow_CatId']}} 
                    </div>
                </div> 
                <div class="row">
                    <div class="col-lg-2">
                        <label class="col-form-labelr align-self-center topic-nomal mb-0">Template : </label>
                    </div>
                    @foreach($flow['template_Id'] as $template_Name)
                        <div class="col-lg-9">
                            {{array_search($template_Name, $flow['template_Id'])+1}}. {{$template_Name}}
                        </div>
                        @if(array_last($flow['template_Id'])!=$template_Name)
                        <div class="col-lg-3"></div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10 block-center">
                <div class="table-responsive" id="listValidator">
                    <table class="table table-list-search font-nomal">
                        <thead>
                            <tr class="center">
                                <th>Step</th>
                                <th>Name</th>
                                <th>Deadline (hr)</th>
                                <th>Verify Type</th>
                                <th>Veridate By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($step as $s)                        
                                <tr class="center">
                                    <td style="text-align:center">{{array_search($s, $step)+1}}</td>
                                    <td>{{$s['step_Title']}}</td>
                                    <td>{{$s['deadline']}}</td>
                                    <td>{{$s['typeOfVerify']}}</td>
                                    <td>{{$s['typeOfValidator']}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>   
                </div>
            </div>
        </div>
    </div>
@endsection