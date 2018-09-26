@extends('layout.Navbar')
@section('script')
    <!-- Data table -->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
@endsection
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
@endsection
@section('content')
    <div class="container">
        <br>
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block">   
                <p class="topic">Your Process List</p>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 d-none d-sm-block">
                <a role="button" class="btn btn-success float-right" href="DataProcess">New Process</a>
            </div>

            {{--  Small screen  --}}
            <div class="col-12 d-sm-none center">   
                <p class="topic">Your Process List</p>
            </div>
            <div class="col-12 d-sm-none ">
                <a role="button" class="btn btn-block btn-success float-right" href="DataProcess">New Process</a>
            </div>
            
        </div>
        <br>
        <ul class="nav nav-tabs " role="tablist">
            <li class="nav-item">
            <a class="nav-link active toggle-nav" data-toggle="tab" href="#onProcess">On Process</a>
            </li>
            <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#successProcess">Success</a>
            </li>
            <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#cancelProcess">Canceled</a>
            </li>
            <li class="nav-item">
                <a class="nav-link toggle-nav" data-toggle="tab" href="#rejectProcess">Rejected</a>
            </li>
        </ul>

        <div class="tab-content">
            {{--  On Process  --}}
            <div id="onProcess" class="container tab-pane active"><br>
                <table class="table table-list-search table-hover" id="onProcess-page">
                    <thead>
                        <tr class="center">
                            <th>Process name</th>
                            <th>Date/Time</th>
                            <th>Stage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $successProcess = array(); $cancelProcess = array(); $rejectProcess = array(); $onprocess=null; @endphp
                        @foreach($allProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            @if($process['current_StepId']=="success")
                                @php array_push($successProcess,$process) @endphp
                            @elseif($process['current_StepId']=="cancel")
                                @php array_push($cancelProcess,$process) @endphp
                            @elseif($process['current_StepId']=="reject")
                                @php array_push($rejectProcess,$process) @endphp
                            @else
                                @php $onprocess = 1 @endphp
                                <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                    <td><div class="text-over">{{$process['process_Name']}}</div></td>
                                    <td class="center">{{$process['created_at']}}</td>
                                    <td class="center">{{$step}}/{{$process['process_Flow']['numberOfStep']}}</td>
                                </tr>
                            @endif
                        @endforeach              
                    </tbody>
                </table>
            </div>

            {{--  Success Process  --}}
            <div id="successProcess" class="container tab-pane fade"><br>
                <table class="table table-list-search table-hover" id="success-page">   
                    <thead>
                        <tr class="center">
                            <th>Process name</th>
                            <th>Date/Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($successProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                <td><div class="text-over">{{$process['process_Name']}}</div></td>
                                <td class="center">{{$process['created_at']}}</td>
                                <td class="center">{{ucfirst($process['current_StepId'])}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{--  Cancel Process  --}}
            <div id="cancelProcess" class="container tab-pane fade"><br>
                <table class="table table-list-search table-hover" id="cancel-page">   
                    <thead>
                        <tr class="center">
                            <th>Process name</th>
                            <th>Date/Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cancelProcess as $process)
                                @php $step = count($process['process_Step'])@endphp
                                <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                    <td><div class="text-over">{{$process['process_Name']}}</div></td>
                                    <td class="center">{{$process['created_at']}}</td>
                                    <td class="center">{{ucfirst($process['current_StepId'])}}</td>
                                </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{--  Reject Process  --}}
            <div id="rejectProcess" class="container tab-pane fade"><br>
                <table class="table table-list-search table-hover" id="reject-page">   
                    <thead>
                        <tr class="center">
                            <th>Process name</th>
                            <th>Date/Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rejectProcess as $process)
                            
                                @php $step = count($process['process_Step'])@endphp
                                <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                    <td><div class="text-over">{{$process['process_Name']}}</div></td>
                                    <td class="center">{{$process['created_at']}}</td>
                                    <td class="center">{{ucfirst($process['current_StepId'])}}</td>
                                </tr>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#onProcess-page').DataTable();
        } );

        $(document).ready( function () {
            $('#success-page').DataTable();
        } );

        $(document).ready( function () {
            $('#cancel-page').DataTable();
        } );

        $(document).ready( function () {
            $('#reject-page').DataTable();
        } );
    </script>
@endsection   