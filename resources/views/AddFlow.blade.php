@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script type="text/javascript">
    function show(userData,validateUrl,about) {
        var isValid = false;
        document.getElementById("err"+about).innerHTML = "" ;
        $.ajax({
            type     : "GET",
            url      : validateUrl,
            data     : userData,
            cache    : false,
            success  : function(response){
                if(response != "true"){                    
                    document.getElementById(about).style.borderColor = "red" ;
                    document.getElementById("err"+about).innerHTML = response ;
                } else {
                    document.getElementById(about).style.borderColor = "green" ;
                }
            }
        });
        if (document.getElementById(about).style.borderColor == "green"){
            isValid = true ;
        }
        return isValid ;
    }
    function nameValidate(){
        var formData = {name : document.getElementById("name").value};
        var isNotErr = show(formData,"NameValidate","name");
        return isNotErr ;
    }
    function deadlineValidate(){
        var formData = {deadline : document.getElementById("deadline").value};
        var isNotErr = show(formData,"DeadlineValidate","deadline");
        return isNotErr ;
    }
    function numStepValidate(){
        var formData = {numberOfStep : document.getElementById("numberOfStep").value};
        var isNotErr = show(formData,"NumStepValidate","numberOfStep");
        return isNotErr ;
    }
    function validateAndSubmit(){
        var name = nameValidate();
        var deadline = deadlineValidate();
        var numStep = numStepValidate();
        if(name&&deadline&&numStep){
            document.getElementById('flow').submit();
        }
    }
    function addCat(){
        document.getElementById("errCat").style.color = "red" ;
        if(document.getElementById("category-name").value == ""){
            document.getElementById("category-name").style.borderColor = "red" ;        
            document.getElementById("errCat").innerHTML = "Please enter category name." ;
        }
        else {
            var cat_Name = {cat_Name : document.getElementById("category-name").value};
            $.ajax({
                type     : "GET",
                url      : "AddCategory",
                data     : cat_Name,
                cache    : false,
                success  : function(response){
                    if(response.listCat != null){
                        document.getElementById("listCat").innerHTML += "<option value='"+response.listCat[response.listCat.length-1].cat_Id+"' selected>"+response.listCat[response.listCat.length-1].cat_Name+"</option>" ;
                        document.getElementById("category-name").style.borderColor = null ;
                        document.getElementById("category-name").value = "";
                        document.getElementById("errCat").innerHTML = "" ;
                        document.getElementById("cancelCat").click() ;
                    }else{
                        document.getElementById("category-name").style.borderColor = "red" ;
                        document.getElementById("errCat").innerHTML = "This category name already exists." ;
                    }
                }
            });
        }
    }
</script>
@endsection
@section('content')
<div class="container content">
    {{-- Large Screen --}}
    <div class="d-none d-sm-block">
        <div class="row">
            <div class="col">
                @if($flow==null)
                    <h3>Create Flow</h3>
                @else
                    <h3>Edit Flow : "{{$flow['flow_Name']}}"</h3>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a class="btn btn-secondary" href="#" role="button">Detail flow</a>
                <a class="btn btn-outline-secondary disabled" href="" role="button">Select template</a>
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
    <form id="flow" action="ListTemplate">
        @if($flow!=null)
            <input type="text" name="flow" value="{{$flow['flow_Id']}}" hidden>
        @endif
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
                    <input type="text" name="name" id="name" onkeyup="nameValidate()" class="form-control" placeholder="Example: การลา" value="{{$flow['flow_Name']}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0"></div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <p id="errname"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Flow Description</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <textarea value="{{$flow['flow_Description']}}" name="desc" class="form-control" placeholder="Emample: ใช้สำหรับลางาน">{{$flow['flow_Description']}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Deadline</label>
                        </div>
                    </div>
                    <div class="col-lg-7 mb-3">
                        <input type="number" value="{{$flow['flow_Deadline']}}" id="deadline" name="deadline" class="form-control" onchange="deadlineValidate()" placeholder="Example: 1"></input>
                    </div>
                    <div class="col-lg-2">
                        Day(s)
                    </div>
                </div><div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0"></div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <p id="errdeadline"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Category</label>
                        </div>
                    </div>
                    <div class="col-lg-7 col-sm-9 col-9 mb-3">
                        @if($flow['flow_CatId']==null)
                            <select class="form-control" name="catId" id="listCat">
                                @foreach($listCat as $cat)
                                    @if($cat['cat_Name']=="อื่นๆ")
                                    @php $otherId = $cat['cat_Id'] @endphp
                                    @else
                                    <option value="{{$cat['cat_Id']}}">{{$cat['cat_Name']}}</option>
                                    @endif
                                @endforeach
                                <option value="{{$otherId}}" selected>อื่นๆ</option>
                            </select>
                        @else
                            <select class="form-control" name="catId" id="listCat">
                                @foreach($listCat as $cat)
                                    @if($cat['cat_Id']==$flow['flow_CatId'])
                                    <option value="{{$cat['cat_Id']}}" selected>{{$cat['cat_Name']}}</option>
                                    @else
                                    <option value="{{$cat['cat_Id']}}">{{$cat['cat_Name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-lg-2 col-sm-3 col-3">
                        <button class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#addCategory">Create</button>
                        <!-- Modal -->
                        <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addCategoryModalLongTitle">Please enter name of category.</h5>               
                                    </div>
                                <div class="modal-body">
                                    <form id="addCat">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="category-name" required>
                                        </div>
                                    </form>
                                    <h6 class="errCat" id="errCat"></h6>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" id="cancelCat" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                        <button type="button" onclick="addCat()" id="saveCat" class="btn btn-primary">save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label>Number of Step</label>
                        </div>
                    </div>
                    <div class="col-lg-7 mb-3">
                        @if($flow['numberOfStep']==null)
                        <input type="number" name="numberOfStep" id="numberOfStep" onchange="numStepValidate()" class="form-control" placeholder="Example: 3" ></input>
                        @elseif(Session::has('FlowCreate'))
                        <input type="number" name="numberOfStep" id="numberOfStep" onchange="numStepValidate()" class="form-control" placeholder="Example: 3" value="{{$flow['numberOfStep']}}"></input>
                        @else
                        <input type="number" name="numberOfStep" id="numberOfStep" class="form-control" placeholder="Example: 3" value="{{$flow['numberOfStep']}}" disabled></input>
                        <input type="hidden" name="numberOfStep" id="numberOfStep" value="{{$flow['numberOfStep']}}"></input>
                        @endif
                    </div>
                    <div class="col-lg-2">
                        Step(s)
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group mb-0"></div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <p id="errnumberOfStep"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8 col-xs-12 text-center">
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#cancelCreateFlowModalCenter">Cancel</button>
                    <!-- Modal -->
                    <div class="modal fade" id="cancelCreateFlowModalCenter" tabindex="-1" role="dialog" aria-labelledby="cancelCreateFlowModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <br><br><br>Do you want to leave this page?<br>
                                    The system does not save your actions.<br><br><br>
                                    <div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                        @if($flow==null)
                                            <a type="button" class="btn btn-secondary" href="ListFlow">Yes</a>
                                        @else
                                            <a type="button" class="btn btn-secondary" href="FlowDetail?id={{$flow['flow_Id']}}">Yes</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <button type="button" onClick="validateAndSubmit()" class="btn btn-success">Next</button>
            </div>
            <div class="col-lg-2"></div>
        </div>       
    </form>
</div>
@endsection