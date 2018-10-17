@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script type="text/javascript">
    function show(userData,validateUrl,about) {
        var isValid = $.Deferred();
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
                    isValid.resolve(false) ;
                } else {
                    document.getElementById(about).style.borderColor = "green" ;
                    isValid.resolve(true) ;
                }
            }
        });
        return isValid ;
    }
    function nameValidate(){
        var formData = {name : document.getElementById("name").value};
        var isNotErr = show(formData,"NameValidate","name");
        return isNotErr ;
    }
    function numStepValidate(){
        var formData = {numberOfStep : document.getElementById("numberOfStep").value};
        var isNotErr = show(formData,"NumStepValidate","numberOfStep");
        return isNotErr ;
    }
    function validateAndSubmit(){
        $.when(nameValidate(),numStepValidate()).then(function ( chk1, chk2 ) {
            if(chk1&&chk2){
                $('BODY').attr('onbeforeunload',false);
                $(window).off("unload");
                document.getElementById('flow').submit();
            }
        });
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
    function notDelSession(){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
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
    $(document).on('change', function () {
        $('BODY').attr('onbeforeunload',"return closeRequest()");
    });
</script>
<div class="container content">
    {{-- Large Screen --}}
    <div class="d-none d-md-block">
        <div class="row">
            <div class="col-lg-12">
                @if($flow==null)
                    <p class="topic">Create Flow</p>
                @else
                    <p class="topic">Create Flow : "{{$flow['flow_Name']}}"</p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a class="btn btn-secondary" href="#" role="button">Detail flow</a>
                @if($flow==null)
                    <a class="btn btn-outline-secondary disabled" href="" role="button">Select template</a>
                @else 
                    <a class="btn btn-outline-secondary" onclick="notDelSession()" href="ListTemplate?flow={{$flow['flow_Id']}}" role="button">Select template</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Small Screen --}}
    <div class="d-md-none">
        <div class="row">
            <div class="col-12 ">
                <p class="topic center">Create Flow</p> 
            </div>
            <div class="col-12 mb-2">
                <div class="dropbown d-inline">
                    <button class="btn btn-block btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <button class="dropdown-item" href="#">Detail flow</button>
                        @if($flow==null)
                            <button class="dropdown-item" href="#" disabled>Select template</button>
                        @else 
                            <button class="dropdown-item" onclick="notDelSession()" href="ListTemplate?flow={{$flow['flow_Id']}}">Select template</button>
                        @endif
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
                            <label class="col-form-labelr align-self-center topic-nomal">Flow Name</label>
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
                    <div class="col-lg-9">
                        <div id="errname" class="err-text"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="topic-nomal">Flow Description</label>
                        </div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <textarea value="{{$flow['flow_Description']}}" name="desc" class="form-control" placeholder="Emample: ใช้สำหรับลางาน">{{$flow['flow_Description']}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0">
                            <label class="topic-nomal">Category</label>
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
                                        <p class="modal-title topic" id="addCategoryModalLongTitle">Please enter name of category.</p>               
                                    </div>
                                <div class="modal-body">
                                    <form id="addCat">
                                        <div class="form-group">
                                            <span class="topic-nomal">Category name</span>
                                            <input type="text" class="form-control" id="category-name" required>
                                        </div>
                                    </form>
                                    <div class="err-text" id="errCat"></div >
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
                    <div class="col-lg-3 col-3 col-md-3">
                        <div class="form-group mb-0">
                            <label class="topic-nomal">Number of Step</label>
                        </div>
                    </div>
                    <div class="col-lg-7 col-6 mb-3 col-md-6">
                        @if($flow['numberOfStep']==null)
                            <input type="number" name="numberOfStep" id="numberOfStep" onkeyup="numStepValidate()" class="form-control" placeholder="Example: 3" >
                        @elseif(Session::has('FlowCreate'))
                            <input type="number" name="numberOfStep" id="numberOfStep" onkeyup="numStepValidate()" class="form-control" placeholder="Example: 3" value="{{$flow['numberOfStep']}}">
                        @endif
                    </div>
                    <div class="col-lg-2 col-2 col-md-3 ">
                        <span class="center topic-nomal">Step(s)</span> 
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group mb-0"></div>
                    </div>
                    <div class="col-lg-9 mb-3">
                        <div class="err-text" id="errnumberOfStep"></div>
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
                                            <a type="button" class="btn btn-secondary" onclick="$('BODY').attr('onbeforeunload',false);" href="/">Yes</a>
                                        @else
                                            <a type="button" class="btn btn-secondary" onclick="$('BODY').attr('onbeforeunload',false);" href="FlowDetail?id={{$flow['flow_Id']}}">Yes</a>
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