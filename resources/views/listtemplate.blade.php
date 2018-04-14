@extends('layout.navbar')
@section('head')
    
@endsection
@section('content')
    <div class="container content">
        <h3 class="lb-txt-bold lb-txt-uppercase lb-txt-18 lb-h3 lb-title">
            Create Flow
        </h3>
        <div class="row">
            <div class="col-lg-10 col-sm-6">
                <div class="d-none d-md-block">
                    <a class="btn btn-outline-primary" href="#" role="button">Detail flow</a>
                    <a class="btn btn-primary" href="" role="button">Select template</a>
                    @for($i=1;$i<=3;$i++)
                        <a class="btn btn-outline-primary" href="#" role="button">Step {{$i}}</a>
                    @endfor
                </div>
                <div class="d-md-none">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Menu
                            </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Detail flow</a>
                            <a class="dropdown-item" href="">Select template</a>
                            @for($i=1;$i<=3;$i++)
                                <a class="dropdown-item" href="#">step{{$i}}</a>
                            @endfor
                            <a class="dropdown-item" href="#">Create</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-sm-6">
                <div class="d-none d-md-block">    
                    <button type="button" class="btn btn-primary button-position">Create</button>
                </div> 
            </div>
            
        </div>

        <div class="row">
            @for($i=1;$i<=7;$i++)
            <div class="col-md-4 col-lg-3 content">
                <img src="pic/user.png" class="card-img-top tempImg">
                <div class="card">
                    <div class="card-body" style="text-align:center">Template {{$i}}</div>
                </div>
            </div>
            @endfor
        </div>
    </div>

    {{-- <div class="row">
        <div>
            <div class="d-none d-md-block">
                <a class="btn btn-outline-primary" href="#" role="button">Detail flow</a>
                <a class="btn btn-primary" href="" role="button">Select template</a>
                @for($i=1;$i<=3;$i++)
                    <button type="button" class="btn btn-outline-primary">step{{$i}}</button>
                @endfor
            </div>
            <div class="d-sm-none">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown button
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Detail flow</a>
                        <a class="dropdown-item" href="#">Select template</a>
                        @for($i=1;$i<=3;$i++)
                            <a class="dropdown-item" href="#">step{{$i}}</a>
                        @endfor 
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-primary button-position">Create</button>
        
    </div>

    <div class="row">
        @for($i=1;$i<=8;$i++)
        <div class="col-md-4 col-lg-2 content">
            <img src="pic/user.png" class="card-img-top tempImg">
            <div class="card">
            <div class="card-body" style="text-align:center">Template {{$i}}</div>
            </div>
        </div>
        @endfor
    </div> --}}

    
@endsection