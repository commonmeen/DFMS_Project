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
    textarea{
        width:100%;
        height: 120px !important;
    }
</style>
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/form-render.min.js"></script>
    <script type="text/javascript">
        function templateSelect(){
            $(".forFormRender").html("");
            document.getElementById('properties').value = "" ;
            var index = document.getElementById('tempId').value ;
            var value ;
            @foreach($template as $temp)
                var tempId = '<?= $temp['template_Id'] ?>';
                if(index==tempId){
                    value = '<?= json_encode($temp['template_Properties'],true) ?>' ;
                }
            @endforeach 
            document.getElementById('properties').value = value ;
            document.getElementById('hide').style.display = "";
            $('.forFormRender').formRender({
                dataType: 'json',
                formData: document.getElementById('properties').value 
            });
        }
        
        function nameValidate(){
            if(document.getElementById("name").value==""){
                var isNotErr = false ;
                document.getElementById("name").style.borderColor = "red" ;
                document.getElementById("errname").innerHTML = "Please enter name of document" ;
            } else {
                var isNotErr = true ;
                document.getElementById("errname").innerHTML = "" ;
                document.getElementById("name").style.borderColor = "" ;
            }
            return isNotErr ;
        }

        function validateAndSubmit(){
            document.getElementById('errDocRequire').innerHTML = "" ;
            $('BODY').attr('onbeforeunload',false);
            if(nameValidate()){
                if(document.getElementById('newDocument').checkValidity()){
                    document.getElementById('newDocument').submit() ;
                } else {
                    document.getElementById('errDocRequire').innerHTML = "** Please check your document, some field is require. **" ;
                }
            } else {
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        }

        function searchTemplate(){
            var word = document.getElementById('search').value ;
            var template = {!! json_encode($template) !!};
            var templateThatSearch = [] ;
            for(var i = 0 ; i<template.length ; i++){
                if(template[i].template_Name.search(word)>=0){
                    templateThatSearch.push(template[i]);
                }
            }
            while( document.getElementById('tempId').options.length-1 ) {
                document.getElementById('tempId').remove(1);
            }
            document.getElementById('tempId').options[0].selected = true;
            for(var i =0; i<templateThatSearch.length ; i++){
                var temp = new Option(templateThatSearch[i].template_Name,templateThatSearch[i].template_Id);
                document.getElementById('tempId').options.add(temp);
            }
            document.getElementById('hide').style.display = 'none';
        }

        function closeRequest(){
            return "You have unsaved changes!";
        }
        
        $(document).ready(function() {
            if(document.getElementById('tempId').value != 'notSelect'){
                templateSelect();
                document.getElementById('hide').style.display = '';
                document.getElementById('search').disabled = true ;
                document.getElementById('topic1').innerHTML = "Edit Document" ;
                document.getElementById('topic2').innerHTML = "Edit Document" ;
            }
        });
    </script>
@endsection

@section('content')
<script>
    $(document).on('change', function () {
        $('BODY').attr('onbeforeunload',"return closeRequest()");
    });
</script>
<div class="container content">
    <form id="newDocument" action="AddDocument" method="POST">
        <div class="row">
            @csrf
            {{--  Large screen  --}}
            <div class="col-12 d-none d-sm-block">
                <p class="topic" id="topic1">New Document</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic" id="topic2">New Document</p>
            </div>
    
            <br>
            <div class="col-12 col-lg-8 mb-2 block-center">
                <span class="topic-nomal">Document name : </span>
                <input type="text" name="name" id="name" class="form-control" onkeyup="nameValidate()" placeholder="Enter Document Name" value="{{$documentData['document_Name']}}">
                <div id="errname" class="err-text"></div>
            </div>
            <div class="col-12 col-lg-8 block-center">
                <div class="row">
                    <div class="col-lg-7 col-12 mb-2">
                        <span class="topic-nomal">Template name : </span>
                        <select class="form-control" name="tempId" id="tempId" onchange="templateSelect()">
                            <option id="defaultNull" disabled selected value="notSelect">Choose Template</option>
                            @for($i=0 ; $i<count($template) ; $i++)
                                @if($documentData['document_TemplateId']==$template[$i]['template_Id'])
                                    <option value="{{$template[$i]['template_Id']}}" selected>{{$template[$i]['template_Name']}}</option>
                                @else
                                    <option value="{{$template[$i]['template_Id']}}">{{$template[$i]['template_Name']}}</option>
                                @endif
                            @endfor                         
                        </select>
                    </div>
                    <div class="col-lg-5 col-12 mb-2">
                        <span class="topic-nomal">Search Template : </span>
                        <input type="text" name="search" id="search" class="form-control" oninput="searchTemplate()" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="hide" style="display:none">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8" style="padding:2%">
                    <input type='hidden' name="prop" id="properties" value=""/>
                    <div class="forFormRender"></div>
                    <p class="center err-text" id="errDocRequire"></p> 
                </div>
                <div class="col-2"></div>
            </div>
            <div class="row">
                <div class="block-center">
                    <a class="btn btn-danger m-2" href="/ListDocument">Cancel</a>
                    <button type="button" class="btn btn-success m-2" onclick="validateAndSubmit()">Save</button>
                </div>
            </div>
        </div>
    </form>
    <br><br>
</div>
@endsection