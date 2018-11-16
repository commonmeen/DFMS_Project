@extends('layout.Navbar') 
@section('script')
    <!-- Data table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="js/jquery.dataTables.min.js"></script>
@endsection
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')   
<div class="container content">
    {{--  Success alert  --}}
    @if(Session::get("alertStatus") == "ApproveSuccess")
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Approve Success! </strong>
            You have successfully approved the process.
        </div>

        <script>
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
        </script>
        {{Session::forget("alertStatus")}}

    @elseif(Session::get("alertStatus") == "RejectSuccess")
        <div class="alert alert-success" id="success-alert">
            <button type="button" class="close" data-dismiss="alert">x</button>
            <strong>Reject Success! </strong>
            You have successfully reject the process.
        </div>

        <script>
        $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
            $("#success-alert").slideUp(500);
        });
        </script>
        {{Session::forget("alertStatus")}}
    @endif

    <div class="row">
        {{--  Large screen  --}}
        <div class="col-12 d-none d-sm-block">
            <p class="topic mb-0" >Your Approve List</p>
        </div>
        {{--  Small screen  --}}
        <div class="col-12 d-sm-none">
            <p class="topic center mb-0">Your Approve List</p>
        </div>
    </div><br>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active toggle-nav" data-toggle="tab" href="#inProgressProcess">In Progress</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#comingProcess">In Coming Document</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#approvedProcess">Approved</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#rejectedProcess">Rejected</a>
        </li>
    </ul>
    <div class="tab-content">
        {{--  In Progress  --}}
        <div id="inProgressProcess" class="container tab-pane active"><br>
            <table class="table table-list-search table-hover" id="inProgress-process">
                <thead>
                    <tr class="center">
                        <th>Flow Name</th>
                        <th>Date/Time</th>
                        <th>Process Owner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nowProcess as $process)
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}&InProgress=true';">
                            <td>{{$process['flowObject']['flow_Name']}}</td>
                            <td class="center">{{$process['updated_at']}}</td>
                            <td class="center">{{$process['ownerObject']['user_Name']}} {{$process['ownerObject']['user_Surname']}}</td>
                        </tr>
                    @endforeach               
                </tbody>
            </table>
        </div>

        {{--  Comming Process  --}}
        <div id="comingProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover" id="comming-process">   
                <thead>
                    <tr class="center">
                        <th>Flow Name</th>
                        <th>Date/Time</th>
                        <th>Process Owner</th>
                        <th>Stage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comingProcess as $process)
                        @php $step = count($process['process_Step'])@endphp
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                            <td>{{$process['flowObject']['flow_Name']}}</td>
                            <td class="center">{{$process['updated_at']}}</td>
                            <td class="center">{{$process['ownerObject']['user_Name']}} {{$process['ownerObject']['user_Surname']}}</td>
                            <td class="center">{{$step}}/{{$process['process_Flow']['numberOfStep']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{--  Approve Process  --}}
        <div id="approvedProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover" id="approved-process">   
                <thead>
                    <tr class="center">
                        <th>Flow Name</th>
                        <th>Date/Time</th>
                        <th>Process Owner</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($passMeProcess as $process)
                        @php $step = count($process['process_Step'])@endphp
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                            <td>{{$process['flowObject']['flow_Name']}}</td>
                            <td class="center">{{$process['updated_at']}}</td>
                            <td class="center">{{$process['ownerObject']['user_Name']}} {{$process['ownerObject']['user_Surname']}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{--  Reject Process  --}}
        <div id="rejectedProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover" id="reject-process">   
                <thead>
                    <tr class="center">
                        <th>Flow Name</th>
                        <th>Date/Time</th>
                        <th>Process Owner</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rejectProcess as $process)
                        @php $step = count($process['process_Step'])@endphp
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                            <td>{{$process['flowObject']['flow_Name']}}</td>
                            <td class="center">{{$process['updated_at']}}</td>
                            <td class="center">{{$process['ownerObject']['user_Name']}} {{$process['ownerObject']['user_Surname']}}</td>
                            <td class="center">{{ucfirst($process['current_StepId'])}}ed</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    <script>
        $(document).ready( function () {
            $('#inProgress-process').DataTable();
        } );

        $(document).ready( function () {
            $('#approved-process').DataTable();
        } );

        $(document).ready( function () {
            $('#comming-process').DataTable();
        } );

        $(document).ready( function () {
            $('#reject-process').DataTable();
        } );



    </script>
@endsection