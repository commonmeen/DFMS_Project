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
        .btn-kv{
            color: 
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
                        document.getElementById('ckDoc').innerHTML += "<div class='col-12 col-md-6 col-lg-4 content' style='text-align:center;display:inline-block'>"+
                        "<input class='c-card' type='checkbox' id='"+response.documentList[i].document_Id+
                        "' value='"+response.documentList[i].document_Id+"' onchange='documentValidate()' name='document_Id[]'>"+
                        "<div class='card-content'>"+
                        "<label for='"+response.documentList[i].document_Id+"'><div class='card-body'>"+response.documentList[i].document_Name+
                        "</div></label></div></div>" ;
                    }
                    if(response.documentList.length == 0){
                        document.getElementById('ckDoc').innerHTML = "<div style='text-align:center'>No document about this flow.</div>";
                        document.getElementById("errDocument").innerHTML = "** Please choose at least 1 document. **" ;
                    }
                    document.getElementById('hide').style.display = "";
                }
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
        
        function documentValidate(){
            var isNotErr = false ;
            var checkbox = document.getElementsByName("document_Id[]") ;
            for (var i = 0, length = checkbox.length; i < length; i++){
                if (checkbox[i].checked){
                    isNotErr = true;
                    document.getElementById("errDocument").innerHTML = "" ;
                    document.getElementById("errDocuments").innerHTML = "" ;
                    break;
                }
                else
                    document.getElementById("errDocument").innerHTML = "Please choose at least 1 document." ;
                    document.getElementById("errDocuments").innerHTML = "Please choose at least 1 document." ;
            }
            return isNotErr;
        }

        function validateAndSubmit(){
            if(documentValidate()&nameValidate()){
                $('BODY').attr('onbeforeunload',false);
                if($('input[type=file]')[0].files.length == 0){
                    document.getElementById('newProcess').submit();
                } else {
                    $("#file-1").fileinput("upload");
                    $('#file-1').on('filebatchuploadsuccess', function(event, data) {
                        document.getElementById('newProcess').submit();
                    }); 
                }
            } else {
                $('html, body').animate({scrollTop:0}, 'slow');
            }
        }
        
        function closeRequest(){
            return "You have unsaved changes!";
        }

        function catSelect(){
            var catFlow = {!! json_encode($catFlow) !!};
            var filterFlow = document.getElementById('catFlow').value;
            while( document.getElementById('flowId').options.length-1 ) {
                document.getElementById('flowId').remove(1);
            }
            console.log(catFlow);
            console.log(filterFlow);
            console.log(catFlow[filterFlow]);

            for(var i =0; i<catFlow[filterFlow].length ; i++){
                console.log(catFlow[filterFlow][i].flow_Name);
                var flow = new Option(catFlow[filterFlow][i].flow_Name,catFlow[filterFlow][i].flow_Id)
                document.getElementById('flowId').options.add(flow);
            }
            
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
    <form id="newProcess" action="NewProcess">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 d-none d-sm-block">
                <p class="topic">Choose Flow</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic">Choose Flow</p>
            </div>
            
            <br>
            <div class="col-12 col-lg-8 mb-2 block-center">
                <span class="topic-nomal">Process name : </span>
                <input type="text" name="name" id="name" class="form-control" onkeyup="nameValidate()" placeholder="Enter Process Name">
                <div id="errname" class="err-text"></div>
            </div>
    
            <div class="col-12 col-lg-8 block-center">
                <div class="row">
                    <div class="col-lg-7 col-12 mb-2">
                        <span class="topic-nomal">Flow name : </span>
                        <select class="form-control" name="flowId" id="flowId" onchange="flowSelect()">
                            <option id="defaultNull" disabled selected value="notSelect">Choose Flow</option>
                                @foreach($flows as $flow)
                                    <option value="{{$flow->flow_Id}}">{{$flow->flow_Name}}</option>
                                @endforeach                            
                        </select>
                    </div>
                    <div class="col-lg-5 col-12 mb-2">
                        <span class="topic-nomal">Filter flow by category : </span>
                        <select class="form-control" id="catFlow" name="catFlow" onchange="catSelect()">
                            <option id="defaultNull" disabled selected value="notSelect">Choose Category</option>
                            @foreach($catFlow as $cat => $flow)
                                <option value="{{$cat}}">{{$cat}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    

        </div>
        <hr>
        <div id="hide" style="display:none">
            <div class="row">
                {{--  Large screen  --}}
                <div class="col-9 col-sm-9 col-lg-9 d-none d-sm-block">
                    <p class="topic" >Choose Document</p>
                    <div class="err-text" id="errDocument"></div>
                </div>
                <div class="col-12 col-sm-3 col-lg-3 d-none d-sm-block">
                    <a role="button" class="btn btn-success float-right" href="NewDocument">New Document</a>
                </div>
                {{--  Small screen  --}}
                <div class="col-12 d-sm-none">
                    <p class="topic center">Choose Document</p>
                </div>
                <div class="col-12 col-sm-3 col-lg-3 d-sm-none">
                    <a role="button" class="btn btn-block btn-success float-right" href="NewDocument">New Document</a>
                    <div class="err-text center" id="errDocuments"></div>
                </div>
                
                <div class="col-12">
                    <p id="ckDoc"></p>
                </div>
            </div>
            <hr>
            <div class="row">
                {{--  Large screen  --}}
                <div class="col-12 d-none d-sm-block">
                    <p class="topic">Upload pic or file (Optional)</p>
                </div>
                {{--  Small screen  --}}
                <div class="col-12 d-sm-none">
                    <p class="topic center">Upload pic or file (Optional)</p>
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
            <hr>
            <div class="row">
                {{--  Large screen  --}}
                <div class="col-12 d-none d-sm-block">
                    <p class="topic">Input Text (Optional)</p>
                </div>
                {{--  Small screen  --}}
                <div class="col-12 d-sm-none">
                    <p class="topic center">Input Text (Optional)</p>
                </div>
                <div class="col-12 col-sm-12 col-11 main-section">
                    <textarea class="col-12" name="textProcess" id="textProcess" rows="4" placeholder="input text here.."></textarea>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="block-center">
                    <a class="btn btn-danger m-2" href="">Cancel</a>
                    <button type="button" class="btn btn-success m-2" onclick="validateAndSubmit()">Enter</button>
                </div>
            </div>
        </div>
    </form>
    <br><br>
</div>
<script type="text/javascript">
    $("#file-1").fileinput({
        removeLabel: "Remove all",
        showUpload: false,
        uploadAsync: false,
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