@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script src="/js/jquery.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/form-render.min.js"></script>
<script>    
    jQuery(function($) {
        $('.fb-render').formRender({
            dataType: 'json',
            formData: document.getElementById('properties').value 
        });
    });
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
                    $('#lockTemplateModalCenter').modal('hide');
                }
            }
        });
    }

    function changeStatus(id,status){
        var data = {template_id:id,newStatus:status};
        $.ajax({
            type     : "GET",
            url      : "LockTemplate",
            data     : data,
            cache    : false,
            success  : function(response){
                window.location.reload();
            }
        });
    }
</script>
@endsection
@section('content')
<div class="container content">
    <div class="row">
        {{--  Large screen  --}}
        <div class="col-sm-6 col-lg-9 d-none d-sm-block mt-3">
            <p class="topic">Template Name : {{$template->template_Name}}</p>
        </div>
        {{--  Small screen  --}}
        <div class="col-12 center d-sm-none mt-3">
            <p class="topic">Template Name : {{$template->template_Name}}</p>
        </div>
        @if($template->status == 'off')
            <div class="col-sm-6 col-lg-3 mt-3">
                <span class="topic-cacel mb-0">( Locked )</span>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-8 block-center">
            <div class="row">
                <div class="col-lg-3">
                    <label class="col-form-labelr align-self-center topic-nomal mb-0">Description : </label>
                </div>
                <div class="col-lg-9">
                    {{$template->template_Description}}
                </div>
            </div>   
            <div class="row">
                <div class="col-lg-3">
                    <label class="col-form-labelr align-self-center topic-nomal mb-0">Owner : </label>
                </div>
                <div class="col-lg-9">
                    {{$template->template_AuthorName}}
                </div>
            </div> 
        </div>
    </div>
    
    <hr>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <input type='hidden' id="properties" value="{{ json_encode($template->template_Properties,true) }}"/>
            <div class="fb-render"></div>
        </div>
        <div class="col-2"></div>
    </div>

    <center>
        <a role="button" class="btn btn-primary" href="EditDocTemplate?temp_id={{$template->template_Id}}">Edit</a>
        @if($template->status=="on")
            <button class="btn red-button " type="button" data-toggle="modal" data-target="#lockTemplateModalCenter">Lock</button>
        @elseif($template->status=="off")
            <button class="btn red-button" type="button" data-toggle="modal" data-target="#lockTemplateModalCenter">Unlock</button>
        @endif
    </center>

    <!-- Lock Modal -->
    <div class="modal fade" id="lockTemplateModalCenter" tabindex="-1" role="dialog" aria-labelledby="lockTemplateModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                @if($template->status=="on")
                    <div class="modal-header alert-title">
                        Do you want to lock "{{$template->template_Name}}" ?
                    </div>
                @elseif($template->status=="off")
                    <div class="modal-header alert-title">
                        "{{$template->template_Name}}" is locked.<br>Do you want to unlock {{$template->template_Name}}?
                    </div>
                @endif
                <div class="modal-body row">
                    <div class="col-lg-3 form-group mb-0">
                        <label class="col-form-labelr align-self-center">Password</label>
                    </div>
                    <div class="col-lg-9">
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <div class="col-lg-3"></div>
                    <div class="col-lg-9">
                        <div id="errPassword" class="err-text"></div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    @if($template->status == "on")
                        <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$template->template_Id}}','off')" >Yes</button>
                    @elseif($template->status == "off") 
                        <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$template->template_Id}}','on')" >Yes</button>
                    @endif   
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection
