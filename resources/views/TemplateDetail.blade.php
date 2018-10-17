@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<style>
    .rendered-form{
        font-size: 18pt !important;
    }
    .fb-checkbox-group-label, .fb-date-label, .fb-number-label, .fb-radio-group-label, .fb-select-label, .fb-text-label, .fb-text-label, .fb-textarea-label {
        font-size: 20pt !important;
        font-weight: bold !important;
        margin-right: 20px !important;
        margin-bottom: 0px !important;
    }
    input{
        border-radius: 3px !important;
        border-style: solid;
        border-width: 1px;
        border-color:darkgray !important;
        font-weight: lighter;
    }
    select, textarea{
        border-radius: 4px !important;
    }
    h1{
        background-color:lightgray !important;
        margin-top: 15px !important;
    }
    .fb-render{
        margin-left:40px !important;
        margin-right: 40px !important;
        margin-top: 20px !important;
        margin-bottom: 20px !important;
    }
    .col-8{
        border-style: solid;
        border-width: 1px;
        border-color: lightgray !important;
        border-radius: 5px !important;
        margin-bottom: 20px !important;
    }
    {{--  div{
        margin-bottom: 20px !important;
    }  --}}
</style>
@endsection
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="http://formbuilder.online/assets/js/form-render.min.js"></script>
<script>    
    jQuery(function($) {
        $('.fb-render').formRender({
            dataType: 'json',
            formData: document.getElementById('properties').value 
        });
    });

    function changeStatus(id,status){
        var data = {template_id:id,newStatus:status};
        console.log(data);
        $.ajax({
            type     : "GET",
            url      : "ChangeTemplateStatus",
            data     : data,
            cache    : false,
            success  : function(response){
                window.location.reload();
            }
        });
    }
</script>
<div class="container content">
    <div class="row">
        {{--  Large screen  --}}
        <div class="col-sm-6 col-lg-6 d-none d-sm-block">
            <p class="topic">Template Name : {{$template->template_Name}}</p>
        </div>
        {{--  Small screen  --}}
        <div class="col-12 center d-sm-none">
            <p class="topic">Template Name : {{$template->template_Name}}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 block-center mt-3 mb-3">
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
        <a role="button" class="btn btn-primary" href="EditFlow?temp_id={{$template->template_Id}}">Edit</a>
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
                        "{{$template->template_Name}}" is locked.<br>Do you want to unlock {{$flow['flow_Name']}}?
                    </div>
                @endif
                <div class="modal-body row">
                    <div class="col-lg-3 form-group mb-0">
                        <label class="col-form-labelr align-self-center">Password</label>
                    </div>
                    <div class="col-lg-8">
                        <input type="text" id="password" name="password" class="form-control">
                    </div>
                    <div class="col-lg-1"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    @if($template->status == "on")
                        <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$template->template_Id}}','off')" data-dismiss="modal">Yes</button>
                    @elseif($template->status == "off") 
                        <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$template->template_Id}}','on')" data-dismiss="modal">Yes</button>
                    @endif   
                </div>
            </div>
        </div>
    </div>  
</div>
@endsection
