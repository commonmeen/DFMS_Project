@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .main-section{
            margin:0 auto;
            padding: 20px;
            background-color: #fff;
            border: hidden;
        }
        .kv-file-upload{
            display: none;
        }   
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
    <script type="text/javascript">
        function flowSelect(){
            var formData = {
                flow_Id : document.getElementById("flowId").value
            };
            $.ajax({
                type     : "GET",
                url      : "GetDocumentByFlow",
                data     : formData,
                cache    : false,
                success  : function(response){
                    document.getElementById('ckDoc').innerHTML = "" ;
                    for(var i=0; i<response.documentList.length ; i++){
                        document.getElementById('ckDoc').innerHTML += "<div class='col-4 content' style='text-align:center;display:inline-block'>"+
                        "<input class='c-card' type='checkbox' id='"+response.documentList[i].document_Id+
                        "' value='"+response.documentList[i].document_Id+"' onchange='documentValidate()' name='document_Id[]'>"+
                        "<div class='card-content'>"+
                        "<label for='"+response.documentList[i].document_Id+"'><div class='card-body'>"+
                        "<p class='text-center font-weight-bold' id='txtName'>"+response.documentList[i].document_Name+"</p>"+
                        "</div></label></div></div>" ;
                    }
                    if(response.documentList.length == 0){
                        document.getElementById('ckDoc').innerHTML = "<div style='text-align:center'>No document about this flow.</div>";
                        document.getElementById("errDocument").innerHTML = "**Please choose at least 1 document." ;
                    }
                    document.getElementById('hide').style.display = "";
                }
            });
        }
        
        function nameValidate(){
            if(document.getElementById("name").value==""){
                var isNotErr = false ;
                document.getElementById("name").style.borderColor = "red" ;
                document.getElementById("name").placeholder = "Please enter name of process" ;
            } else {
                var isNotErr = true ;
                document.getElementById("name").style.borderColor = "" ;
            }
            return isNotErr ;
        }
        
        function documentValidate(){
            var isNotErr = false ;
            var checkbox = document.getElementsByName("document_Id[]") ;
            for (var i = 0, length = checkbox.length; i < length; i++){
                if (checkbox[i].checked){
                    isNotErr = true;
                    document.getElementById("errDocument").innerHTML = "" ;
                    break;
                }
                else
                    document.getElementById("errDocument").innerHTML = "**Please choose at least 1 document." ;
            }
            return isNotErr;
        }

        function validateAndSubmit(){
            $("#file-1").fileinput({
                uploadUrl: "/FileUpload"
            });
            if(documentValidate()&nameValidate())
                document.getElementById('newProcess').submit();
            else
                $('html, body').animate({scrollTop:0}, 'slow');
        }
    </script>
@endsection
@section('content')
<div class="container content">
    <form id="newProcess" action="NewProcess">
        <div class="row">
            <div class="col-12">
                <h5>Choose Flow</h5>
            </div>
            <br>
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-sm-9 col-9 mb-3">
                <input type="text" name="name" id="name" class="form-control" onkeyup="nameValidate()" placeholder="Enter Process Name">
            </div>
            <div class="col-lg-2"></div><div class="col-lg-2"></div>
            <div class="col-lg-8 col-sm-9 col-9 mb-3">
                <select class="form-control" name="flowId" id="flowId" onchange="flowSelect()">
                    <option id="defaultNull" disabled selected value="notSelect">Choose Flow</option>
                    @foreach($flows as $flow)
                        <option value="{{$flow->flow_Id}}">{{$flow->flow_Name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2"></div>
        </div>
        <hr><br>
        <div id="hide" style="display:none">
            <div class="row">
                <div class="col-9">
                    <h5 style="display:inline;">Choose Document</h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p style="color:red; display:inline;" id="errDocument"></p>
                </div>
                <div class="col-3">
                    <a role="button" class="btn btn-primary float-right" href="NewDocument">New Document</a>
                </div>
                <div class="col-12">
                    <p id="ckDoc"></p>
                </div>
            </div>
            <hr><br>
            <div class="row">
                <div class="col-12">
                    <h5>Upload pic or file (Optional)</h5>
                </div>
                <div class="col-lg-12 col-sm-12 col-11 main-section">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="file-loading">
                            <input id="file-1" type="file" name="file[]" multiple data-overwrite-initial="false">
                        </div>
                    </div>
                </div>
            </div>
            <hr><br>
            <div class="row">
                <div class="col-12">
                    <h5>Input Text (Optional)</h5>
                </div>
                <div class="col-12 col-sm-12 col-11 main-section">
                    <textarea class="col-12" name="textProcess" id="textProcess" uploadUrl="/FileUpload" rows="4" placeholder="input text here.."></textarea>
                </div>
            </div>
            <hr><br>
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 text-center">
                        <a class="btn btn-danger m-2" href="">Cancel</a>
                        <button type="button" class="btn btn-success m-2" onclick="validateAndSubmit()">Sent</button>
                    </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </form>
    <br><br>
</div>
<script type="text/javascript">
    $("#file-1").fileinput({
        removeLabel: "Remove all",
        showUpload: false,
        theme: 'fa',
        uploadUrl: "/FileUpload",
        uploadExtraData: function() {
            return {
                _token: $("input[name='_token']").val(),
            };
        },
        allowedFileExtensions: ['jpeg', 'jpg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'txt'],
        overwriteInitial: false,
        maxFileSize:10000,
        maxFilesNum: 10,
        slugCallback: function (filename) {
            return filename;
        }
    });
</script>
@endsection