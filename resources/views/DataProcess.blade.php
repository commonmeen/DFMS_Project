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
@endsection

@section('content')
{{-- test open pdf file  --}}
{{-- <a href="upload/resume (1).pdf" target="_blank">Open the pdf!</a> --}}
<div class="container content">
    <div class="row">
        <div class="col-12">
            <h5>Choose Document</h5>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 content">
            <input class="c-card" type="checkbox" id="11" value="11" name="template_Id[]" checked>
            <div class="card-content">
                <div class="card-state-icon"></div>
                <label for="11">
                    <img src="pic/contract.png" class="card-img-top tempImg">
                    <div class="card-body ">
                        <p class="text-center font-weight-bold ">11</p>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 content">
            <input class="c-card" type="checkbox" id="22" value="22" name="template_Id[]">
            <div class="card-content">
                <div class="card-state-icon"></div>
                <label for="22">
                    <img src="pic/contract.png" class="card-img-top tempImg">
                    <div class="card-body ">
                        <p class="text-center font-weight-bold ">22</p>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 content">
            <input class="c-card" type="checkbox" id="33" value="33" name="template_Id[]" >
            <div class="card-content">
                <div class="card-state-icon"></div>
                <label for="33">
                    <img src="pic/contract.png" class="card-img-top tempImg">
                    <div class="card-body">
                        <p class="text-center font-weight-bold ">33</p>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <hr><br>
    <div class="row">
        <div class="col-12">
            <h5>Upload pic or file (If any)</h5>
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
            <h5>Input Text (If any)</h5>
        </div>
        <div class="col-12 col-sm-12 col-11 main-section">
            <textarea class="col-12"  rows="4" placeholder="input text here.."></textarea>
        </div>
    </div>
    <hr><br>
    <div class="row">
        <div class="col-lg-2"></div>
            <div class="col-lg-8 col-xs-12 text-center">
                <a class="btn btn-danger m-2" href="">Cancel</a>
                <button type="button" class="btn btn-success m-2" onClick="validateAndSubmit()">Sent</button>
            </div>
        <div class="col-lg-2"></div>
    </div>
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