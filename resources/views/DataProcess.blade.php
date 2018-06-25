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
        .fileinput-remove{
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
                        document.getElementById('ckDoc').innerHTML += "<div class='col-6 content' style='text-align:center'>"+
                        "<input class='c-card' type='checkbox' id='"+response.documentList[i].document_Id+
                        "' value='"+response.documentList[i].document_Id+"' name='document_Id[]'>"+
                        "<div class='card-content'><div class='card-state-icon'></div>"+
                        "<label for='"+response.documentList[i].document_Id+"'><div class='card-body'>"+
                        "<p class='text-center font-weight-bold' id='txtName'>"+response.documentList[i].document_Name+"</p>"+
                        "</div></label></div></div>" ;
                    }
                    document.getElementById('hide').style.display = "";
                }
            });
        }
    </script>
@endsection
@section('content')
<div class="container content">
    <form action="NewProcess">
        <div class="row">
            <div class="col-12">
                <h5>Choose Flow</h5>
            </div>
            <br>
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-sm-9 col-9 mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Process Name">
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
                <div class="col-12">
                    <h5>Choose Document</h5>
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
                            <input id="file-1" type="file" name="file" multiple data-overwrite-initial="false">
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
                    <textarea class="col-12" name="textProcess" id="textProcess" rows="4" placeholder="input text here.."></textarea>
                </div>
            </div>
            <hr><br>
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 text-center">
                        <a class="btn btn-danger m-2" href="">Cancel</a>
                        <input type="submit" class="btn btn-success m-2" value="Sent"></input>
                    </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </form>
    <br><br>
</div>
<script type="text/javascript">
    $.fn.fileinput.defaults.showRemove = false;
    $("#file-1").fileinput({
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