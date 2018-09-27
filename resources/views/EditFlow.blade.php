@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script type="text/javascript">
    window.onload = function() {
        var url = window.location.href;
        if(url.indexOf("#") != -1){
            var activeTab = url.substring(url.indexOf("#") + 1);
            $("#" + activeTab).addClass("active in");
            $('a[href="#'+ activeTab +'"]').tab('show');
        }
    };
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
    function nameValidate(){
        var formData = {name : document.getElementById("name").value};
        var isNotErr = show(formData,"NameValidate","name");
        return isNotErr ;
    }
    function changeStep(stepId,change){
        $.ajax({
            type     : "GET",
            url      : "ChangeStep",
            data     : {step_Id :stepId, status:change},
            cache    : false,
            success  : function(response){
                for(var i=0; i<response.step.length ; i++){
                    var j = i ;
                    if(j+1 != 1 && j+1 != response.step.length){
                        document.getElementById(i+"Row").innerHTML = "<td><div "+
                        "class='row'><input type='image' src='pic/sort-up.png' onclick=changeStep('"+response.step[i].step_Id+"','minus') style='width:18px;height:16px;margin-right:-30px;'/></div>"+
                        "<div class='row'><input type='image' src='pic/sort-down.png' onclick=changeStep('"+response.step[i].step_Id+"','plus') style='width:18px;height:16px;margin-right:-30px;'/></div>" ;
                    } else if(j+1 != response.step.length){
                        document.getElementById(i+"Row").innerHTML = "<td><div "+
                        "class='row'><input type='image' src='pic/sort-up.png' style='width:18px;height:16px;margin-right:-30px;filter:grayscale(100%);'/></div>"+
                        "<div class='row'><input type='image' src='pic/sort-down.png' onclick=changeStep('"+response.step[i].step_Id+"','plus') style='width:18px;height:16px;margin-right:-30px;'/></div>" ;
                    } else if(j+1 != 1){
                        document.getElementById(i+"Row").innerHTML = "<td><div "+
                        "class='row'><input type='image' src='pic/sort-up.png' onclick=changeStep('"+response.step[i].step_Id+"','minus') style='width:18px;height:16px;margin-right:-30px;'/></div>"+
                        "<div class='row'><input type='image' src='pic/sort-down.png' style='width:18px;height:16px;margin-right:-30px;filter:opacity(0.2);'/></div>" ;
                    } else {
                        document.getElementById(i+"Row").innerHTML = "<td><div "+
                        "class='row'><input type='image' src='pic/sort-up.png' style='width:18px;height:16px;margin-right:-30px;filter:grayscale(100%);'/></div>"+
                        "<div class='row'><input type='image' src='pic/sort-down.png' style='width:18px;height:16px;margin-right:-30px;filter:opacity(0.2);'/></div>" ;                    
                    }
                    document.getElementById(i+"Row").innerHTML += "</td><td class='center' onclick=window.location='EditStep?id="+response.step[i].step_Id+"';"+
                    "style='text-align:center'>"+(j+1)+"</td>"+
                    "<td onclick=window.location='EditStep?id="+response.step[i].step_Id+"';>"+response.step[i].step_Title+"</td>"+
                    "<td class='center' onclick=window.location='EditStep?id="+response.step[i].step_Id+"';>"+response.step[i].deadline+"</td>"+
                    "<td class='center' onclick=window.location='EditStep?id="+response.step[i].step_Id+"';>"+response.step[i].typeOfVerify+"</td>"+
                    "<td class='center'onclick=window.location='EditStep?id="+response.step[i].step_Id+"';>"+response.step[i].typeOfValidator+"</td>"+
                    "<td class='center'><input type='image' src='pic/bin-step.png' onclick=changeStep('"+response.step[i].step_Id+"','delete') style='width:24px;height:24px;'/></td>";
                }
                if(change=="delete"){
                    document.getElementById(response.step.length+"Row").innerHTML = "" ;
                }
            }
        });
    }
    function stepAddRequest(flow_Id){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        window.location="AddStep?flow_Id="+flow_Id+"&step";
    }
    function stepCancelRequest(flow_Id){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        window.location="FlowDetail?id="+flow_Id;
    }
    function stepEditRequest(step_Id){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        window.location="EditStep?id="+step_Id;
    }
    function submitDetail(){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        if(nameValidate()){
            document.getElementById('DetailForm').submit();
        }
    }
    function submitTemplate(){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        document.getElementById('TemplateForm').submit();
    }
    function submitStep(){
        $('BODY').attr('onbeforeunload',false);
        $(window).off("unload");
        $('#submitStepModal').modal();
        $('#submitYes').click(function() {
            // check password
            $.ajax({
                type     : "GET",
                url      : "ChangeStepSave",
                data     : {},
                cache    : false,
                success  : function(response){
                    window.location='FlowDetail?id='+ response.newFlowId ;
                }
            });
            $('#submitStepModal').modal('hide');
        });
    }
    function closeRequest(){
        return "You have unsaved changes!" ;
    }
    $(window).on("unload",function () {
        $.ajax({
            type: 'GET',
            async: false,
            url: 'clear/session/FlowEdit'
        });
        $.ajax({
            type: 'GET',
            async: false,
            url: 'clear/session/stepChange'
        });
    });
</script>
@endsection
@section('content')
<script>
    $('BODY').attr('onbeforeunload',"return closeRequest()");
</script>
<div class="container content">
    <div class="row">
        {{-- Large screen --}}
        <div class="col-sm-6 col-lg-6 d-none d-sm-block">
            <p class="topic">Edit Flow : "{{$flow['flow_Name']}}"</p>
        </div>
        {{-- Small screen --}}
        <div class="col-12 center d-sm-none">
            <p class="topic">Edit Flow : "{{$flow['flow_Name']}}"</p>
        </div>
    </div>
    
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active toggle-nav" data-toggle="tab" href="#flowDetail">Edit Detail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#flowTemplate" aria-disabled="true">Edit Template</a>
        </li>
        <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#flowStep">Edit Step</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="flowDetail" class="container tab-pane active"><br>
            <form id="DetailForm" action="ListTemplate">
                <input type="text" name="flow" value="{{$flow['flow_Id']}}" hidden>
                <div class="row">
                    <div class="col-lg-8 col-xs-12 block-center">
                        <div class="row">
                            <div class="col-lg-3 horizon-center">
                                <div class="form-group mb-0">
                                    <label class="col-form-labelr align-self-center topic-nomal">Flow Name</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="name" id="name" onkeyup="nameValidate()" class="form-control" placeholder="Example: การลา" value="{{$flow['flow_Name']}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-9 mb-3 err-text" id="errname"></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 horizon-center">
                                <div class="form-group mb-0">
                                    <label class="topic-nomal">Flow Description</label>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <textarea name="desc" class="form-control" placeholder="Example: ใช้สำหรับลางาน">{{$flow['flow_Description']}}</textarea>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-3 horizon-center">
                                <div class="form-group mb-0">
                                    <label class="topic-nomal">Category</label>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-9 col-9">
                                <select class="form-control" name="catId" id="listCat">
                                    @foreach($listCat as $cat)
                                        @if($cat['cat_Id']==$flow['flow_CatId'])
                                            <option value="{{$cat['cat_Id']}}" selected>{{$cat['cat_Name']}}</option>
                                        @else
                                            <option value="{{$cat['cat_Id']}}">{{$cat['cat_Name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2 col-sm-3 col-3">
                                <button class="btn btn-primary float-right" type="button" data-toggle="modal" data-target="#addCategory">Create</button>
                                <!-- Modal -->
                                <div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <p class="modal-title alert-title" id="addCategoryModalLongTitle">Please enter name of category.</p>               
                                            </div>
                                        <div class="modal-body">
                                            <div class="col-lg-4 form-group mb-0 ">
                                                <label>Category name</label> 
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" class="form-control" id="category-name" required>
                                            </div>
                                            <div class="col-lg-12 err-text" id="errCat"></div>
                                        </div>
                                            <div class="modal-footer">
                                                <button type="button" id="cancelCat" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                                                <button type="button" onclick="addCat()" id="saveCat" class="btn btn-primary">save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-3 horizon-center">
                                <div class="form-group mb-0 ">
                                    <label class="topic-nomal">Number of Step</label>
                                </div>
                            </div>
                            <div class="col-lg-7 col-sm-9 col-9">
                                <input type="number" name="numberOfStep" id="numberOfStep" class="form-control" placeholder="Example: 3" value="{{$flow['numberOfStep']}}" disabled></input>
                                <input type="hidden" name="numberOfStep" id="numberOfStep" value="{{$flow['numberOfStep']}}"></input>
                            </div>
                            <div class="col-lg-2 col-sm-3 col-3 horizon-center topic-nomal">Step(s)</div>
                        </div>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-lg-8 col-xs-12 text-center block-center">
                        <button type="button" class="btn btn-danger m-2" onclick="stepCancelRequest('{{$flow['flow_Id']}}')">Cancel</button>
                        <button type="button" class="btn btn-success mb-0" onclick="submitDetail()">Save</button>
                    </div>
                </div>       
            </form>
        </div>
        <div id="flowTemplate" class="container tab-pane fade"><br>
            <form id="TemplateForm" action="AddFlowTemplate">
                <input type="text" name="flow_Id" value="{{$flow['flow_Id']}}" hidden>
                {{-- Large screen --}}
                <div class="d-none d-sm-block">
                    <div class="row">
                        <div class="col">
                            <p>Select Template</p>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success  float-right" onClick="submitTemplate()">Save</button>
                            <a role="button" class="btn btn-primary float-right mr-2" href="AddTemplate">Create</a>
                        </div>
                    </div>
                </div>
                {{-- Small screen --}}
                <div class="d-sm-none">
                    <div class="row">
                        <div class="col-12 center">
                            <p class="mb-0">Select Template</p>
                        </div>
                        <div class="col-12">
                            <button type="button" class="btn btn-success btn-block  float-right" onClick="submitTemplate()">Save</button>
                            <a role="button" class="btn btn-primary btn-block float-right center" href="AddTemplate">Create</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach($template as $t)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 content">
                            @if($flow['template_Id']!=null)
                                @foreach($flow['template_Id'] as $flowTem)
                                    @if($t['template_Id']==$flowTem)
                                        <input class="c-card" type="checkbox" id="{{$t['template_Id']}}" value="{{$t['template_Id']}}" name="template_Id[]" checked>
                                        @php array_shift($flow['template_Id']); @endphp
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
                                        <p class="center mb-0 img-font">{{$t['template_Name']}}</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
        <div id="flowStep" class="container tab-pane fade"><br>
            <div class="row">
                <div class="col-lg-10 block-center">
                    <div class="table-responsive" id="listValidator">
                        <table class="table table-list-search table-hover">
                            <thead>
                                <tr class="center">
                                    <th></th>
                                    <th>Step</th>
                                    <th>Name</th>
                                    <th>Deadline(hr)</th>
                                    <th>Verify Type</th>
                                    <th>Veridate By</th>
                                    <th><input type="image" src="pic/add-button.png" style="width:22px;height:22px;" onclick="stepAddRequest('{{$flow['flow_Id']}}')"/></th>
                                </tr>
                            </thead>                           
                            <tbody>
                                @foreach ($step as $s)                        
                                    <tr id="{{array_search($s, $step)}}Row">
                                        <td style="text-align:right">
                                            @if(array_search($s, $step)+1 != 1)
                                                <div class="row">
                                                    <input type="image" src="pic/sort-up.png" onclick="changeStep('{{$s['step_Id']}}','minus')" style="width:18px;height:16px;margin-right:-30px;"/>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <input type="image" src="pic/sort-up.png" style="width:18px;height:16px;margin-right:-30px;filter:grayscale(100%)"/>
                                                </div>
                                            @endif
                                            @if(array_search($s, $step)+1 != count($step))
                                                <div class="row">
                                                    <input type="image" src="pic/sort-down.png" onclick="changeStep('{{$s['step_Id']}}','plus')" style="width:18px;height:16px;margin-right:-30px;"/>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <input type="image" src="pic/sort-down.png" style="width:18px;height:16px;margin-right:-30px;filter:opacity(0.2);"/>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="center" onclick="stepEditRequest('{{$s['step_Id']}}')" style="text-align:center">{{array_search($s, $step)+1}}</td>
                                        <td onclick="stepEditRequest('{{$s['step_Id']}}')">{{$s['step_Title']}}</td>
                                        <td class="center" onclick="stepEditRequest('{{$s['step_Id']}}')">{{$s['deadline']}}</td>
                                        <td class="center" onclick="stepEditRequest('{{$s['step_Id']}}')">{{$s['typeOfVerify']}}</td>
                                        <td class="center" onclick="stepEditRequest('{{$s['step_Id']}}')">{{$s['typeOfValidator']}}</td>
                                        <td class='center'><input type="image" src="pic/bin-step.png" onclick="changeStep('{{$s['step_Id']}}','delete')" style="width:24px;height:24px;"/></td>
                                    </tr>
                                @endforeach
                            </tbody>                            
                        </table>
                        <div class="modal fade" id="submitStepModal" tabindex="-1" role="dialog" aria-labelledby="cancelCreateFlowModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    
                                        <div class="modal-header alert-title">
                                            Do you want to save ?
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-lg-3 form-group mb-0 horizon-center">
                                                    <label class="col-form-labelr align-self-center">password</label>
                                                </div>
                                                <div class="col-lg-8">
                                                    <input type="text" name="password" class="form-control">
                                                </div>
                                                <div class="col-lg-1"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                            <button type="button" class="btn btn-secondary" id="submitYes">Yes</button>
                                        </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-xs-12 text-center block-center">
                    <a class="btn btn-danger m-2" href="" >Cancel</a>
                    <button type="button" onClick="submitStep()" class="btn btn-success mb-0">Save</button>
                </div>
            </div>   
        </div>
    </div>
</div>
@endsection