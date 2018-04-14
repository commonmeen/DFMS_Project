@extends('layout.navbar')
@section('head')
    <link type="text/css" href="../css/AddFlow.css" rel="stylesheet">
@endsection
@section('content')

<div class="container content">
    {{-- Large Screen --}}
    <div class="d-none d-sm-block">
        <div class="row">
            <div class="col">
                <h3>Create Flow</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-primary" href="#" role="button">Detail flow</button>
                <button class="btn btn-outline-primary" href="" role="button" disabled>Select template</button>
            </div>
        </div>
    </div>

    {{-- Small Screen --}}
    <div class="d-sm-none">
        <div class="row">
            <div class="col">
                <span class="top-menu">Create Flow</span> 
                <div class="dropbown d-inline ml-5">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" href="#">Detail flow</button>
                        <button class="dropdown-item" href="" disabled>Select template</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="ListTemplate">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-xs-12">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="col-form-labelr align-self-center">Flow Name</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Example">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Flow Description</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <textarea  name="desc" class="form-control" placeholder="Emample"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Deadline</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <input type="number"  name="deadline" class="form-control" placeholder="7 days"></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Category</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <select class="form-control" name="catId" id="exampleFormControlSelect1">
                            @foreach($listCat as $cat)
                                <option value="{{$cat['cat_Id']}}">{{$cat['cat_Name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Number of Step</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <input type="number" name="numberOfStep" class="form-control" placeholder="10 steps"></input>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-xs-12 text-center">
                <a role="button" class="btn btn-danger m-2" href="listflow">Cancel</a>
                <button type="submit" value="submit" class="btn btn-success m-2">Next</button>
            </div>
            <div class="col-lg-2"></div>
        </div>        
    </form>
    


</div>
@endsection