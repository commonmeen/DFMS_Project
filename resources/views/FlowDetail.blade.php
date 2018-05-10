@extends('layout.Navbar') 
@section('content')   
    <div class="container content">
        <div class="row">
            <div class="col-lg-6">
                <h3>Flow : {{$flow['flow_Name']}}</h3>
            </div>
            <div class="col-lg-3">
                <a role="button" class="btn btn-primary float-right" href="">Edit</a>
            </div>
            <div class="col-lg-3 text-center">
                <button class="btn btn-primary float-left" type="button" data-toggle="modal" data-target="#lockFlowModalCenter">Lock</button>
                <!-- Modal -->
                <div class="modal fade" id="lockFlowModalCenter" tabindex="-1" role="dialog" aria-labelledby="lockFlowModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <br><br><br>Do you want to Lock {{$flow['flow_Name']}}?<br><br>
                                <div class="row mb-3">
                                    <div class="col-lg-3 form-group mb-0">
                                        <label class="col-form-labelr align-self-center">password</label>
                                    </div>
                                    <div class="col-lg-8 mb-3">
                                        <input type="text" name="password" class="form-control">
                                    </div>
                                    <div class="col-lg-1"></div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                    <a type="button" class="btn btn-secondary" href="">Yes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <form action="">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="row mb-5"></div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Description : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_Description']}}
                        </div>
                    </div>   
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Deadline : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_Deadline']}} Day(s)
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Category : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            {{$flow['flow_CatId']}} 
                        </div>
                    </div> 
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="col-form-labelr align-self-center">Template : </label>
                        </div>
                        <div class="col-lg-9 mb-3">
                            ... 
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class=" table-responsive" id="listValidator">
                        <table class="table table-list-search " >
                            <thead>
                                <tr>
                                    <th>Step</th>
                                    <th>Name</th>
                                    <th>Verify Type</th>
                                    <th>Veridate By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($step as $s)
                                    <tr>
                                        <td>{{$s->step_Id}}</td>
                                        <td>{{$s->step_Title}}</td>
                                        <td>{{$s->typeOfVerify}}</td>
                                        <td>{{$s->typeOfValidator}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>   
                    </div>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </form>
    </div>
@endsection