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
</style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
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
                document.getElementById("errname").innerHTML = "Please enter name of process" ;
            } else {
                var isNotErr = true ;
                document.getElementById("errname").innerHTML = "" ;
                document.getElementById("name").style.borderColor = "" ;
            }
            return isNotErr ;
        }

        function validateAndSubmit(){
            if(nameValidate()){
                document.getElementById('newDocument').submit() ;
            } else {
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        }
        
        function closeRequest(){
            return "You have unsaved changes!";
        }
    </script>
@endsection

@section('content')
<script>
    $(document).on('change', function () {
        $('BODY').attr('onbeforeunload',"return closeRequest()");
    });
</script>
<div class="container content">
    <form id="newDocument" action="AddDocument">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 d-none d-sm-block">
                <p class="topic">New Document</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic">New Document</p>
            </div>
    
            <br>
            <div class="col-12 col-lg-8 mb-2 block-center">
                <span class="topic-nomal">Document name : </span>
                <input type="text" name="name" id="name" class="form-control" onkeyup="nameValidate()" placeholder="Enter Document Name">
                <div id="errname" class="err-text"></div>
            </div>
            <div class="col-12 col-lg-8 block-center">
                <div class="row">
                    <div class="col-lg-7 col-12 mb-2">
                        <span class="topic-nomal">Template name : </span>
                        <select class="form-control" name="tempId" id="tempId" onchange="templateSelect()">
                            <option id="defaultNull" disabled selected value="notSelect">Choose Template</option>
                                @for($i=0 ; $i<count($template) ; $i++)
            
                                    <option value="{{$template[$i]['template_Id']}}">{{$template[$i]['template_Name']}}</option>
                                @endfor                         
                        </select>
                    </div>
                    <div class="col-lg-5 col-12 mb-2">
                        <span class="topic-nomal">Search Template : </span>
                        <input type="text" name="search" id="search" class="form-control" onkeyup="" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="hide" style="display:none">
            <div class="row">
                    <div class="col-2"></div>
                    <div class="col-8">
                        <input type='hidden' name="prop" id="properties" value=""/>
                        <div class="forFormRender"></div> 
                    </div>
                    <div class="col-2"></div>
                </div>
            <div class="row">
                <div class="block-center">
                    <a class="btn btn-danger m-2" href="">Cancel</a>
                    <button type="button" class="btn btn-success m-2" onclick="validateAndSubmit()">Save</button>
                </div>
            </div>
        </div>
    </form>
    <br><br>
</div>
@endsection