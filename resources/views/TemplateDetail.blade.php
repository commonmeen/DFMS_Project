@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
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
        
        <!-- Lock Modal -->
        {{-- <div class="modal fade" id="lockTemplateModalCenter" tabindex="-1" role="dialog" aria-labelledby="lockTemplateModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    @if($flow['status']=="on")
                        <div class="modal-header alert-title">
                            Do you want to lock "{{$flow['flow_Name']}}" ?
                        </div>
                    @elseif($flow['status']=="off")
                        <div class="modal-header alert-title">
                            "{{$flow['flow_Name']}}" is locked.<br>Do you want to unlock {{$flow['flow_Name']}}?
                        </div>
                    @endif
                    <di v class="modal-body row">
                        <div class="col-lg-3 form-group mb-0">
                            <label class="col-form-labelr align-self-center">Password</label>
                        </div>
                        <div class="col-lg-8">
                            <input type="text" name="password" class="form-control">
                        </div>
                        <div class="col-lg-1"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        @if($flow['status']=="on")
                            <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$flow['flow_Id']}}','off')" data-dismiss="modal">Yes</button>
                        @elseif($flow['status']=="off") 
                            <button type="button" class="btn btn-secondary" onclick="changeStatus('{{$flow['flow_Id']}}','on')" data-dismiss="modal">Yes</button>
                        @endif   
                    </div>
                </div>
            </div>
        </div>   --}}
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
    <input type='hidden' id="properties" value="{{ json_encode($template->template_Properties,true) }}"/>
    <div class="fb-render">
    </div>
    <center>
        <a role="button" class="btn btn-primary" href="EditFlow?temp_id={{$template->template_Id}}">Edit</a>
        {{-- @if($template['status']=="on") --}}
            <button class="btn red-button float-left" type="button" data-toggle="modal" data-target="#lockTemplateModalCenter">Lock</button>
        {{-- @elseif($template['status']=="off") --}}
            {{-- <button class="btn red-button float-left" type="button" data-toggle="modal" data-target="#lockTemplateModalCenter">Unlock</button> --}}
    </center>
</div>
@endsection
