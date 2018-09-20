@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')
    <div class="container " style="font-size:20pt">
        <br>
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block">   
                <p class="topic">Create Document Template</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 d-sm-none center">   
                <p class="topic">Create Document Template</p>
            </div>            
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <label class="col-form-labelr align-self-center topic-nomal">Name : </label>
                </div>
            </div>
            <div class="col-lg-9 mb-3">
                <input type="text" name="name" id="name" onkeyup="" class="form-control" placeholder="Example: แบบฟอร์มการขอยืมอุปกรณ์" value="">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group mb-0">
                    <label class="col-form-labelr align-self-center topic-nomal">Description : </label>
                </div>
            </div>
            <div class="col-lg-9 mb-3">
                <textarea name="desc" class="form-control" placeholder="Emample: ใช้สำหรับสร้างเอกสารเพื่อขอยืมอุปกรณ์ในคณะเท่านั้น"></textarea>
            </div>
        </div>
        <div id="build-wrap"></div>
        <div class="fb-render"></div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-render.min.js"></script>
    <script>
              
            jQuery(function($) {
                var fbEditor = $(document.getElementById('build-wrap'));
                var fields = [{
                    label: "Time",
                    type: "text",
                    subtype: "time",
                    icon: '⧖'
                }];
                var options = {
                    fields: fields,
                    subtypes: {
                        text: ['time']
                    },
                    disableFields: ['autocomplete','button','file','paragraph'],
                    disabledActionButtons: ['data'],
                    onSave: function() {
                        var $data = formBuilder.actions.getData('json');
                        var $decode = jQuery.parseJSON($data);
                        console.log($decode);
                        fbEditor.toggle();
                        $('.fb-render').formRender({
                            formData: formBuilder.formData
                        });
                    }
                };
                var formBuilder = $(fbEditor).formBuilder(options);
            });
    </script>
@endsection
