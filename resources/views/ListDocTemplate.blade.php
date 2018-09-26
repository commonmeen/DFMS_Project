@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"/>
<script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
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
    <ul class="nav nav-tabs " role="tablist">
        <li class="nav-item">
            <a class="nav-link active toggle-nav" data-toggle="tab" href="#all">All Template</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#trash">Trash</a>
        </li>
    </ul>

    <div class="tab-content">
        {{--  all tab  --}}
        <div id="all" class="container tab-pane active"><br>
            <table class="table table-list-search table-hover" id="allTemp">
                <thead>
                    <tr class="center">
                        <th>Template name</th>
                        <th>Author</th>
                        <th>Last Update</th>
                        <th><span hidden>Modify</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allTemplate as $template)
                        <tr onclick="window.location='TemplateDetail?temp_id={{$template['template_Id']}}';">
                            <td><div class="text-over">{{$template['template_Name']}}</div></td>
                            <td class="center">{{$template['template_AuthorName']}}</td>
                            <td class="center">{{$template['created_at']}}</td>
                            <td><input type="image" src="pic/writing.png" onclick="window.location='';" style="width:24px;height:24px;"/>&nbsp;&nbsp;&nbsp;<input type="image" src="pic/lock.png" onclick="" style="width:24px;height:24px;"/></td>
                        </tr>
                    @endforeach              
                </tbody>
            </table>
        </div>

        {{--  trash tab  --}}
        <div id="trash" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover" id="success-page">   
                <thead>
                    <tr class="center">
                        <th>Process name</th>
                        <th>Date/Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($successProcess as $process)
                        @php $step = count($process['process_Step'])@endphp
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                            <td><div class="text-over">{{$process['process_Name']}}</div></td>
                            <td class="center">{{$process['created_at']}}</td>
                            <td class="center">{{ucfirst($process['current_StepId'])}}</td>
                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection