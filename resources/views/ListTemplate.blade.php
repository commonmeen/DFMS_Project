@extends('layout.Navbar')
@section('content')
    <div class="container content">
        <form action="AddFlowTemplate">
            @if($Flow['numberOfStep']==0)
                <input type="text" name="flow_Id" value="{{$Flow['flow_Id']}}" hidden>
            @endif
        {{-- Large Screen --}}
    <div class="d-none d-sm-block">
        <div class="row">
            <div class="col">
                <h3>Create Flow</h3>
            </div>
            <div class="col">
                <input type="submit" class="btn btn-success float-right " value="Next">
                <a role="button" class="btn btn-primary float-right mr-2" href="AddTemplate">Create</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn-outline-secondary" href="" role="button">Detail flow</a>
                <a class="btn btn-secondary" href="#" role="button" >Select template</a>
                @for($i=1;$i<=$Flow['numberOfStep'];$i++)
                    <a class="btn btn-outline-secondary" href="" role="button" >Step {{$i}}</a>
                @endfor
            </div>
        </div>
    </div>

    {{-- Small Screen --}}
    <div class="d-sm-none">
        <div class="row">
            <div class="col-12">
                <p class="top-menu text-center">Create Flow</p>
            </div>
        </div>
        <div class="row">
            <div class="col-4 ">
                <div class="dropbown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Detail flow</a>
                        <a class="dropdown-item" href="" >Select template</a>
                        @for($i=1;$i<=$Flow['numberOfStep'];$i++)
                            <a class="dropdown-item" href="#">Step {{$i}}</a>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-8">
                <input type="submit" class="btn btn-success  float-right" value="Next">
                <a role="button" class="btn btn-primary float-right mr-2" href="AddTemplate">Create</a>
            </div>         
        </div>   
    </div>        
            
    
            <div class="row">
                @foreach($template as $t )
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 content">
                    @foreach($Flow['template_Id'] as $flowTem)
                    @if($t['template_Id']==$flowTem)
                    <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]" checked>
                    @else
                    <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]">
                    @endif
                    @endforeach
                        <div class="card-content">
                            <div class="card-state-icon"></div>
                            <label for="{{$t['template_Id']}}">
                                <img src="pic/user.png" alt="{{$t['template_Name']}}" class="card-img-top tempImg">
                                <div class="card-body ">
                                    <p class="text-center font-weight-bold ">{{$t['template_Name']}}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </div>

@endsection