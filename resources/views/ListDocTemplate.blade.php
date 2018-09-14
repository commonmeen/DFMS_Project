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
                <p class="topic">Document Template</p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 d-sm-none center">   
                <p class="topic">Document Template</p>
            </div>            
        </div>


        <div id="build-wrap"></div>
        <div id="fb-rendered-form">
            <form action="#"></form>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script>
              
            jQuery(function($) {
                var fbEditor = $(document.getElementById('build-wrap'));
                var formContainer = $(document.getElementById('fb-rendered-form'));
                var options = {
                    onSave: function() {
                        var $data = formBuilder.actions.getData('json');
                        var $decode = jQuery.parseJSON($data);
                        console.log($decode);
                        
                        fbEditor.toggle();
                        formContainer.toggle();
                        $('form', formContainer).formRender({
                            formData: formBuilder.formData
                        });
                      }
                };
                var formBuilder = $(fbEditor).formBuilder(options);
            });
    </script>
@endsection
