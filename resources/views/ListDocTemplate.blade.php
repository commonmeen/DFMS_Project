@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#allTemp').DataTable();
    } );
</script>
@endsection
@section('content')
<div class="container">
    <br>
    <div class="row">
        {{--  Large screen  --}}
        <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block">   
            <p class="topic">Template List</p>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 d-none d-sm-block">
            <a role="button" class="btn btn-success float-right" href="AddDocTemplate">New Template</a>
        </div>
        {{--  Small screen  --}}
        <div class="col-12 d-sm-none center">   
            <p class="topic">Template List</p>
        </div>
        <div class="col-12 d-sm-none ">
            <a role="button" class="btn btn-block btn-success float-right" href="AddDocTemplate">New Template</a>
        </div>
    </div>

    <div class="tab-content">
        {{--  all tab  --}}
        <div id="all" class="container tab-pane active"><br>
            <table class="table table-list-search table-hover" id="allTemp">
                <thead>
                    <tr class="center">
                        <th>Template name</th>
                        <th>Author</th>
                        <th>Last Update</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allTemplate as $template)
                        @if($template['status']=='on' || $template['status']=='off')
                            <tr onclick="window.location='TemplateDetail?temp_id={{$template['template_Id']}}';">
                                <td><div class="text-over">{{$template['template_Name']}}</div></td>
                                <td class="center">{{$template['template_AuthorName']}}</td>
                                <td class="center">{{$template['created_at']}}</td>
                                @if($template['status']=='off')
                                <td class="center"><img src="pic/lock.png" style="width:24px;height:24px;"><span hidden>lock</span></td>
                                @else
                                <td></td>
                                @endif
                            </tr>
                        @endif
                    @endforeach              
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection