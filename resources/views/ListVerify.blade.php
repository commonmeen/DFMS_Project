@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('content')   
<div class="container"><br>
    <div class="row">
        <div class="col-5">   
            <h4>Verify List</h4>
        </div>
    </div><br>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#inProgressProcess">In Progress</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#comingProcess">Coming</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#approvedProcess">Approved</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#rejectedProcess">Rejected/Canceled</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="inProgressProcess" class="container tab-pane active"><br>
            <table class="table table-list-search table-hover">
                <tbody>
                    @foreach($nowProcess as $process)
                        <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}&InProgress=true';">
                            <td>{{$process['process_Name']}}</td>
                            <td>{{$process['updated_at']}}</td>
                        </tr>
                    @endforeach   
                    @if(count($nowProcess)==0)
                        <thead>
                            <tr>
                                <td style="text-align:center">
                                    No Process in Progress.
                                </td>
                            </tr>
                        </thead>
                    @endif             
                </tbody>
            </table>
        </div>
        <div id="comingProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover">   
                @if(count($comingProcess) == 0)
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                No Process Coming.
                            </td>
                        </tr>
                    </thead>
                @else
                    <tbody>
                        @foreach($comingProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$step}}/{{$process['process_Flow']['numberOfStep']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <div id="approvedProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover">   
                @if(count($passMeProcess) == 0)
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                No Process Approved.
                            </td>
                        </tr>
                    </thead>
                @else
                    <tbody>
                        @foreach($passMeProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$process['updated_at']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <div id="rejectedProcess" class="container tab-pane fade"><br>
            <table class="table table-list-search table-hover">   
                @if(count($rejectProcess) == 0)
                    <thead>
                        <tr>
                            <td style="text-align:center">
                                No Process Rejected.
                            </td>
                        </tr>
                    </thead>
                @else
                    <tbody>
                        @foreach($rejectProcess as $process)
                            @php $step = count($process['process_Step'])@endphp
                            <tr onclick="window.location='ProcessDetail?id={{$process['process_Id']}}';">
                                <td>{{$process['process_Name']}}</td>
                                <td>{{$process['current_StepId']}}ed</td>
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection