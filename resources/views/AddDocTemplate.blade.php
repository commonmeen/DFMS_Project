@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<style>
    .add-opt{
        font-size: 18pt !important;
        background-color: lightgreen !important;
    }
    .fb-header{
        background-color:lightgray !important;
        text-align: center !important;
    }
    .remove{
        font-size: 120% !important;
    }
    .form-control, .tooltip-element, .sortable-options{
        font-size: 16pt !important;
    }
    .form-group, .input{
        font-size: 18pt !important;
    }
    .fld-subtype{
        height: 35px !important;
    } 
    .fb-checkbox-inline, .fb-radio-inline{
        margin-left: 3% !important;
        margin-right: 3% !important;
    }
    input{
        border-radius: 3px !important;
    }
</style>
@endsection
@section('content')
    <div class="container " style="font-size:20pt">
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block mt-3">   
                <p class="topic">Create Document Template</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 d-sm-none center mt-3">   
                <p class="topic">Create Document Template</p>
            </div>            
            <div class="col-lg-8 col-12 block-center">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="col-form-labelr align-self-center topic-nomal">Name : </label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <input type="text" name="name" id="name" onkeyup="" class="form-control input" placeholder="Example: แบบฟอร์มการขอยืมอุปกรณ์" value="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="col-form-labelr align-self-center topic-nomal">Description : </label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <textarea id="desc" name="desc" class="form-control input" placeholder="Emample: ใช้สำหรับสร้างเอกสารเพื่อขอยืมอุปกรณ์ในคณะเท่านั้น"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        <div id="build-wrap"></div>
        <div class="fb-render"></div>
        <center>
            <button type="button" class="btn mt-3 btn-danger" id="clear">Clear</button>
            <button type="button" class="btn mt-3 btn-success" id="save">Save</button>
        </center>
        <input type="hidden" id="token" value="{{csrf_token()}}">
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
                typeUserAttrs: {
                    date: {
                        value: {
                            label: 'Date default',
                            type: 'date',
                            value: ''
                        },
                        min: {
                            label: 'Date min.',
                            type: 'date',
                            value: ''
                        },
                        max: {
                            label: 'Date max.',
                            type: 'date',
                            value: ''
                        },
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    'radio-group': {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    'checkbox-group': {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    number : {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    select : {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    text : {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    },
                    textarea : {
                        name: {
                            label: ' ',
                            type: 'text',
                            value: '',
                            hidden: true
                        }
                    }
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
                data = {_token:document.getElementById('token').value, title : document.getElementById('name').value,desc : document.getElementById('desc').value,formData: formData}
                $.ajax({
                    type     : "POST",
                    url      : 'SaveDocTemplate',
                    data     : data,
                    cache    : false,
                    success  : function(response){
                        if(response.temp != null){
                            window.location = "/ListDocTemplate";
                            {{Session::put('tempStatus','AddTemplate')}}
                        }    
                    }
                });
                ////// ตัวอย่างการ render //////
                // $('.fb-render').formRender({
                //     dataType: 'json',
                //     formData: response.temp.template_Properties 
                // });
            });
            var formBuilder = $(fbEditor).formBuilder(options);
        });
    </script>
@endsection