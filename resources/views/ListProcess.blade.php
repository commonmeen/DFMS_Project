@extends('layout.Navbar')
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
        <div class="col-5">   
            <h4>Your Process List</h4>
        </div>
        <div class="col-6 ">
            <a role="button" class="btn btn-success float-right" href="NewProcess">New Process</a>
        </div>
        <div class="col-1"></div>
    </div>
    <br>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#onProcess">On Process</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#successProcess">Success</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#cancelProcess">Cancel</a>
        </li>
    </ul>

    <div class="tab-content">
        <div id="onProcess" class="container tab-pane active"><br>
            <table class="table table-list-search table-hover">
                <tbody>
                    @php $successProcess = array(); $cancelProcess = array() @endphp
                    @foreach($allProcess as $process)
                    @php $step = count($process['process_Step'])@endphp
                        @if($process['current_StepId']=="success")
                            @php array_push($successProcess,$process) @endphp
                        @elseif($process['current_StepId']=="cancel")
                            @php array_push($cancelProcess,$process) @endphp
                        @else
                            <tr onclick="window.location='ProcessDeatil?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$step}}/{{$process['process_Flow']['numberOfStep']}}</td>
                            </tr>
                        @endif
                    @endforeach                            
                </tbody>
            </table>
        </div>
        <div id="successProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover">   
                @if(count($successProcess) == 0)
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                No Successful Process.
                            </td>
                        </tr>
                    </thead>
                @else
                    <tbody>
                        @foreach($successProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDeatil?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$step}}/{{$process['process_flow']['numberOfStep']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <div id="cancelProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover">   
                @if(count($cancelProcess) == 0)
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                No Process Canceled.
                            </td>
                        </tr>
                    </thead>
                @else
                    <tbody>
                        @foreach($cancelProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDeatil?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$step}}/{{$process['process_flow']['numberOfStep']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>

@endsection   