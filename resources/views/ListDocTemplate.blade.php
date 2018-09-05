@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')
    <div class="container " style="font-size:20pt">
        <div id="fb-editor" class="block-top"></div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script>
    jQuery(function($) {
        $(document.getElementById('fb-editor')).formBuilder();
    });
    console.log(document.getElementById('fb-editor').value);
    </script>
@endsection
