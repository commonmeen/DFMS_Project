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
                <textarea id="desc" name="desc" class="form-control" placeholder="Emample: ใช้สำหรับสร้างเอกสารเพื่อขอยืมอุปกรณ์ในคณะเท่านั้น"></textarea>
            </div>
        </div>
        <div id="build-wrap"></div>
        <div class="fb-render"></div>
        <center>
            <button type="button" class="mt-3 btn-danger" id="clear">Clear</button>
            <button type="button" class="mt-3 btn-success" id="save">Save</button>
        </center>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-render.min.js"></script>
    <script>    
        jQuery(function($) {
            var fbEditor = $(document.getElementById('build-wrap'));
            var fields = [
                {
                    label: "Time",
                    type: "text",
                    subtype: "time",
                    icon: '⧖'
                },{
                    label: "Label",
                    type: "header",
                    icon: '𝒍'
                },{
                    label: "Text",
                    type: "text"
                },{
                    label: "Radio Button",
                    type: "radio-group"
                },{
                    label: "Checkbox",
                    type: "checkbox-group"
                },{
                    label: "Dropdown",
                    type: "select"
                },{
                    label: "Date",
                    type: "date"
                }
            ];
            var options = {
                fields: fields,
                subtypes: {
                    text: ['time']
                },
                typeUserAttrs: {
                    date: {
                        min: {
                            label: 'Date minimum',
                            maxlength: '10',
                            description: 'Minimum'
                        },
                        max: {
                            label: 'Date max.',
                            maxlength: '10',
                            onclick: 'alert("wooohoooo")'
                        }
                    }
                },
                disabledAttrs: ["className", "access","name"],
                typeUserDisabledAttrs: {
                    'checkbox-group': [
                        'toggle'
                    ],
                    'date':[
                        'placeholder'
                    ],
                    'select':[
                        'placeholder'
                    ],
                    'textarea':[
                        'subtype'
                    ]
                },
                disableFields: [
                    'autocomplete',
                    'date',
                    'select',
                    'checkbox-group',
                    'button',
                    'file',
                    'paragraph',
                    'hidden',
                    'header',
                    'text',
                    'radio-group'
                ],
                showActionButtons: false
            };
            document.getElementById('clear').addEventListener('click', function() {
                formBuilder.actions.clearFields();
            });
            document.getElementById('save').addEventListener('click', function() {
                fbEditor.toggle();
                formData = formBuilder.actions.getData('json');
                data = {title : document.getElementById('name').value,desc : document.getElementById('desc').value,formData: formData}
                console.log(formData);
                // window.location='AddDocTemplate';
                $.ajax({
                    type     : "GET",
                    url      : 'SaveDocTemplate',
                    data     : data,
                    cache    : false,
                    success  : function(response){
                        console.log("bye",response);
                        $('.fb-render').formRender({
                            dataType: 'json',
                            formData: response.temp.template_Properties 
                        });
                    }
                });
                // $('.fb-render').formRender({
                //     dataType: 'json',
                //     formData: formBuilder.actions.getData('json')
                // });
            });
            var formBuilder = $(fbEditor).formBuilder(options);
        });
    </script>
@endsection
