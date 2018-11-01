@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script type="text/javascript">
    function notDelSession(){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
    }
    function submitForm(){
        notDelSession();
        document.getElementById('flowTemplate').submit();
    }
    $(window).on("unload",function () {
        $.ajax({
            type: 'GET',
            async: false,
            url: 'clear/session/FlowCreate'
        });
    });
    function closeRequest(){
        return "You have unsaved changes!";
    }
</script>
@endsection
@section('content')
<script>
    $('BODY').attr('onbeforeunload',"return closeRequest()");
</script>
    <div class="container content">
        <form id="flowTemplate" action="AddFlowTemplate">
            @if($Flow['numberOfStep']==0)
                <input type="text" name="flow_Id" value="{{$Flow['flow_Id']}}" hidden>
            @endif
        {{-- Large Screen --}}
            <div class="d-none d-sm-block">
                <div class="row">
                    <div class="col">
                        <p class="topic">Create Process Flow : "{{$Flow['flow_Name']}}"</p>
                    </div>
                    <div class="col">
                        <button onclick="submitForm()" class="btn btn-success  float-right">Next</button>
                        <a role="button" onclick="notDelSession()" class="btn btn-primary float-right mr-2" href="AddTemplate">Create</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col"> 
                        <a class="btn btn-outline-secondary" onclick="notDelSession()" href="AddFlow?flow_Id={{$Flow['flow_Id']}}" role="button">Detail flow</a>
                        <a class="btn btn-secondary" href="#" role="button" >Select template</a>
                        @for($i=1;$i<=$Flow['numberOfStep'];$i++)
                            @if(count($allStepId)>=$i)
                                <a class="btn btn-outline-secondary" onclick="notDelSession()" href="EditStep?id={{$allStepId[$i-1]}}&stepck={{$i}}" role="button">Step {{$i}}</a>
                            @else
                                <a class="btn btn-outline-secondary disabled" href="" role="button" >Step {{$i}}</a>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
            {{-- Small Screen --}}
            <div class="d-sm-none">
                <div class="row">
                    <div class="col-12">
                        <p class="topic center">Create Process Flow</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="dropbown">
                            <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Menu
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" onclick="notDelSession()" href="AddFlow?flow_Id={{$Flow['flow_Id']}}">Detail flow</a>
                                <a class="dropdown-item" href="#" >Select template</a>
                                @for($i=1;$i<=$Flow['numberOfStep'];$i++) 
                                    @if(count($allStepId)>=$i)
                                        <a class="dropdown-item" onclick="notDelSession()" href="EditStep?id={{$allStepId[$i-1]}}&stepck={{$i}}">Step {{$i}}</a>
                                    @else
                                        <a class="dropdown-item disabled" href="">Step {{$i}}</a>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <a role="button" onclick="notDelSession()" class="btn btn-primary btn-block" href="AddTemplate">Create</a>
                    </div>
                    <div class="col-6">
                        <button onclick="submitForm()" class="btn btn-success btn-block float-right">Next</button>
                    </div>         
                </div>   
            </div>        
            <div class="row">
                @foreach($template as $t )
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 content">
                    @if($Flow['template_Id']!=null)
                        @foreach($Flow['template_Id'] as $flowTem)
                            @if($t['template_Id']==$flowTem)
                                <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]" checked>
                                @php array_shift($Flow['template_Id']); @endphp
                                @break
                            @else
                                <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]">
                                @break    
                            @endif
                        @endforeach
                    @else
                        <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]">
                    @endif
                        <div class="card-content">
                            <div class="card-state-icon"></div>
                            <label for="{{$t['template_Id']}}">
                                <img src="pic/contract.png" alt="{{$t['template_Name']}}" class="card-img-top tempImg mt-1">
                                <div class="card-body ">
                                    <p class="img-font center">{{$t['template_Name']}}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>
@endsection