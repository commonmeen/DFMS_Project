@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
<script type="text/javascript">
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
            <div class="col-lg-6">
                <h3>Flow : {{$flow['flow_Name']}}</h3>
            </div>
            <div class="col-lg-3">
            <a role="button" class="btn btn-primary float-right" href="AddFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div>
            <div class="col-lg-3 text-center">
                @if($flow['status']=="on")
                    <button class="btn btn-primary float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Lock</button>
                @elseif($flow['status']=="off")
                    <button class="btn btn-primary float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Unlock</button>
                @endif
            <!-- Modal -->
                <div class="modal fade" id="lockFlowModalCenter" tabindex="-1" role="dialog" aria-labelledby="lockFlowModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                @if($flow['status']=="on")
                                <br><br><br>Do you want to lock {{$flow['flow_Name']}}?<br><br>
                                @elseif($flow['status']=="off")
                                <br><br><br>{{$flow['flow_Name']}} is locked.<br>Do you want to unlock {{$flow['flow_Name']}}?<br><br>
                                @endif
                                <div class="row mb-3">
                                    <div class="col-lg-3 form-group mb-0">
                                        <label class="col-form-labelr align-self-center">password</label>
                                    </div>
                                    <div class="col-lg-8 mb-3">
                                        <input type="text" name="password" class="form-control">
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    @if($flow['status']=="on")
                                        <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$flow['flow_Id']}}','off')" data-dismiss="modal">Yes</button>
                                    @elseif($flow['status']=="off") 
                                        <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$flow['flow_Id']}}','on')" data-dismiss="modal">Yes</button>
                                    @endif   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <form action="">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="row mb-5"></div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Description : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_Description']}}
                        </div>
                    </div>   
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Deadline : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_Deadline']}} Day(s)
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Category : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_CatId']}} 
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Template : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            ... 
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class=" table-responsive" id="listValidator">
                        <table class="table table-list-search " >
                            <thead>
                                <tr>
                                    <th>Step</th>
                                    <th>Name</th>
                                    <th>Verify Type</th>
                                    <th>Veridate By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($step as $s)
                                    <tr>
                                        <td>{{$s->step_Id}}</td>
                                        <td>{{$s->step_Title}}</td>
                                        <td>{{$s->typeOfVerify}}</td>
                                        <td>{{$s->typeOfValidator}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>   
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </form>
    </div>
@endsection