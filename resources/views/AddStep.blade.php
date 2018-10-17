@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script type="text/javascript">
    function find(){
        var formData = {
            search : document.getElementById("search").value
        };
        document.getElementById("defaultNull").selected = true  ;
        $.ajax({
            type     : "GET",
            url      : "SearchUser",
            data     : formData,
            cache    : false,
            success  : function(response){
                document.getElementById('userTable').innerHTML = "" ;
                document.getElementById('notFoundErr').innerHTML = "";
                if(response.searchAll.length>0){
                    for(var i=0; i<response.searchAll.length ; i++){
                        document.getElementById('userTable').innerHTML += "<tr><td><div class='ckbox'>"+
                        "<input type='checkbox' name='validator[]' onchange='validatorCheckValidate()'"+
                        "value='"+response.searchAll[i].user_Id+
                        "' id='"+response.searchAll[i].user_Id+
                        "'></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+
                        "</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+
                        "</td><td id='user_Email'>"+response.searchAll[i].user_Email+
                        "</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
                    }
                } else {
                    document.getElementById('notFoundErr').innerHTML = "Sorry, We couldn’t find any name/surname matching <b>'"+document.getElementById("search").value+"'</b>";
                }
            }
        });
    }

    function hiddenn(h) {
        document.getElementById("selectPosition").style.display = 'none';
        document.getElementById("search").style.display = 'none';
        document.getElementById("position").style.display = 'none';
        document.getElementById("listValidator").style.display = 'none';
        if(h==0){
            document.getElementById("selectPosition").style.display = '';
        }else if(h==1){
            document.getElementById("search").style.display = '';
            document.getElementById("position").style.display = '';
            document.getElementById("listValidator").style.display = '';
        }
    }

    function searchPosition(){
        var p_Id = document.getElementById("position").value ;
        $.ajax({
            type     : "GET",
            url      : "SearchPosition",
            data     : { position_Id : p_Id },
            cache    : false,
            success  : function(response){
                document.getElementById('userTable').innerHTML = "" ;
                document.getElementById('notFoundErr').innerHTML = "";
                if(response.searchAll.length>0){
                    for(var i=0; i<response.searchAll.length ; i++){
                        document.getElementById('userTable').innerHTML += "<tr><td><div class='ckbox'>"+
                        "<input type='checkbox' name='validator[]' onchange='validatorCheckValidate()'"+
                        "value='"+response.searchAll[i].user_Id+
                        "' id='"+response.searchAll[i].user_Id+
                        "'></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+
                        "</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+
                        "</td><td id='user_Email'>"+response.searchAll[i].user_Email+
                        "</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
                    }
                } else {
                    document.getElementById('notFoundErr').innerHTML = "Sorry, We couldn’t find any name/surname in <b>'"+document.getElementById(p_Id).innerHTML+"'</b>";
                }
            }
        });
    }

    function showSelectVal(users){
        users = JSON.parse(users);
        $.ajax({
            type     : "GET",
            url      : "GetSelectValidator",
            data     : { userIds : users },
            cache    : false,
            success  : function(response){
                document.getElementById('userTable').innerHTML = "" ;
                for(var i=0; i<response.searchAll.length ; i++){
                    document.getElementById('userTable').innerHTML += "<tr><td><div class='ckbox'>"+
                    "<input type='checkbox' name='validator[]' onchange='validatorCheckValidate()'"+
                    "value='"+response.searchAll[i].user_Id+
                    "' id='"+response.searchAll[i].user_Id+
                    "' checked></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+
                    "</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+
                    "</td><td id='user_Email'>"+response.searchAll[i].user_Email+
                    "</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
                }
            }
        });
    }

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

    function titleValidate(){
        var formData = {title : document.getElementById("title").value};
        var isNotErr = show(formData,"AddStepTitleValidate","title");
        return isNotErr ;
    }

    function deadlineValidate(){
        var formData = {deadline : document.getElementById("deadline").value};
        var isNotErr = show(formData,"AddStepDeadlineValidate","deadline");
        return isNotErr ;
    }

    function verifyValidate(){
         var isNotErr = false ;
         var radio = document.getElementsByName("type")
         for (var i = 0, length = radio.length; i < length; i++){
            if (radio[i].checked){
                isNotErr = true ;
                document.getElementById("errverify").innerHTML = "" ;
                break;
            }
         }
         if(!isNotErr){
            document.getElementById("errverify").innerHTML = "Verify type is require" ;
         }       
         return isNotErr ;
     }

    function validatorValidate(){
         var isNotErr = false ;
         var radio = document.getElementsByName("selectBy")
         for (var i = 0, length = radio.length; i < length; i++){
            if (radio[i].checked){
                isNotErr = true ;
                hiddenn(i);
                document.getElementById("errvalidator").innerHTML = "" ;
                break;
            }
         }
         if(!isNotErr){
            document.getElementById("errvalidator").innerHTML = "Validator type is require" ;
         }       
         return isNotErr ;
     }

     function validatorCheckValidate(){
        var isNotErr = false ;
         if(document.getElementsByName("selectBy")[1].checked){
            var checkbox = document.getElementsByName("validator[]") ;
            for (var i = 0, length = checkbox.length; i < length; i++){
                if (checkbox[i].checked){
                    isNotErr = true ;
                    document.getElementById("errvalidator").innerHTML = "" ;
                    break;
                }
            }
         } else {
            isNotErr = true ;
         }
         if(!isNotErr){
            document.getElementById("errvalidator").innerHTML = "Plase search and select validator" ;
         } 
         return isNotErr ;
     }

    function validateAndSubmit(){
        var title = titleValidate();
        var verify = verifyValidate();
        var deadline = deadlineValidate();
        var validator = validatorValidate();
        var validatorck = validatorCheckValidate();
        if(title&&deadline&&verify&&validator&&validatorck){
            notDelSession() ;
            document.getElementById('step').submit();
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
        $.ajax({
            type: 'GET',
            async: false,
            url: 'clear/session/FlowEdit'
        });
        $.ajax({
            type: 'GET',
            async: false,
            url: 'clear/session/stepEdit'
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
        @if($step!=null)
        {{-- Large Screen --}}
        <div class="d-none d-sm-block">
            <div class="row">
                <div class="col">
                <p class="topic">Create Flow  : "{{$flow['flow_Name']}}"</p>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <a class="btn btn-outline-secondary" onclick="notDelSession()" href="AddFlow?flow_Id={{$flow['flow_Id']}}" role="button" >Detail flow</a>
                    <a class="btn btn-outline-secondary" onclick="notDelSession()" href="ListTemplate?flow={{$flow['flow_Id']}}" role="button" >Select template</a>
                    @for($i=1;$i<=$flow['numberOfStep'];$i++)
                        @if($step==$i)
                            <a class="btn btn-secondary" href="#" role="button" >Step {{$i}}</a>
                        @elseif($step>$i)
                            <a class="btn btn-outline-secondary" onclick="notDelSession()" href="EditStep?id={{$allStep[$i-1]}}&stepck={{$i}}" role="button">Step {{$i}}</a>
                        @elseif($step<$i)
                            @if(count($allStep)>=$i)
                                <a class="btn btn-outline-secondary" onclick="notDelSession()" href="EditStep?id={{$allStep[$i-1]}}&stepck={{$i}}" role="button">Step {{$i}}</a>
                            @else
                                <a class="btn btn-outline-secondary disabled" href="" role="button">Step {{$i}}</a>
                            @endif   
                        @endif
                    @endfor
                </div>
            </div>
        </div>
        
    {{-- Small Screen --}}
        <div class="d-sm-none">
            <div class="row">
                <div class="col">
                    <p class="topic center">Create Flow : "{{$flow['flow_Name']}}"</p> 
                    <div class="dropbown d-inline">
                        <button class="btn btn-secondary btn-block dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" onclick="notDelSession()" href="AddFlow?flow_Id={{$flow['flow_Id']}}">Detail flow</button>
                            <button class="dropdown-item" onclick="notDelSession()" href="ListTemplate?flow={{$flow['flow_Id']}}">Select template</button>
                            @for($i=1;$i<=$flow['numberOfStep'];$i++)
                            @if($step==$i)
                                <button class="dropdown-item" href="#"  >Step {{$i}}</button>
                            @elseif($step>$i)
                                <button class="dropdown-item" onclick="notDelSession()" href="EditStep?id={{$allStep[$i-1]}}&stepck={{$i}}" >Step {{$i}}</button>
                            @elseif($step<$i)
                                <button class="dropdown-item" href="" disabled>Step {{$i}}</button>
                            @endif
                        @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="d-none d-sm-block">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="topic">Edit Flow  : "{{$flow['flow_Name']}}"</p>
                    </div>
                    <div class="col-lg-6 float-right">
                        @if(isset($stepNumber))
                            <p class="topic" style="text-align:right">Step number : {{$stepNumber}}</p>
                        @endif
                        {{--  <p class="topic" style="text-align:right">Step number : {{$stepNumber}}</p>                        --}}
                    </div>
                </div>
            </div>
            
        @endif

        <form action="AddStep" id="step">
            <input type="text" name="flow_Id" value="{{$flow['flow_Id']}}" hidden>
            <div class="row">
                <div class="col-lg-9 col-xs-12 block-center">
                    <div class="row mb-2">
                        <div class="col-lg-3 justify-content-center align-self-center">
                            <label class="topic-nomal horizon-center">Name</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" id="title" name="title" class="form-control" value="{{$stepData['step_Title']}}" placeholder="Example" onkeyup="titleValidate()">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-0"></div>
                        </div>
                        <div class="col-lg-9">
                            <p id="errtitle" class="err-text"></p>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 justify-content-center align-self-center">
                            <label class="topic-nomal horizon-center">Verify By</label>
                        </div>
                        
                        <label class="col-lg-3 radio-inline mb-0 horizon-center">
                            @if($stepData['typeOfVerify']!="allow")
                                <input type="radio" onchange="verifyValidate()" name="type" value="allow" id="allow"> Allow
                            @else
                                <input type="radio" onchange="verifyValidate()" name="type" value="allow" id="allow" checked> Allow
                            @endif 
                        </label>
                        <label class="col-lg-3 radio-inline mb-0 horizon-center">
                            @if($stepData['typeOfVerify']!="password")
                                <input type="radio" onchange="verifyValidate()" name="type" value="password" id="password"> Password
                            @else
                                <input type="radio" onchange="verifyValidate()" name="type" value="password" id="password" checked> Password
                            @endif 
                        </label>
                        <label class="col-lg-3 radio-inline mb-0 horizon-center">
                            @if($stepData['typeOfVerify']!="otp")
                                <input type="radio" onchange="verifyValidate()" name="type" value="otp" id="OTP"> OTP
                            @else
                                <input type="radio" onchange="verifyValidate()" name="type" value="otp" id="OTP" checked> OTP
                            @endif 
                        </label>                                    
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-0"></div>
                        </div>
                        <div class="col-lg-9">
                            <p id="errverify" class="err-text"></p>
                        </div>
                    </div>
                
                    <div class="row mb-2">
                        <div class="col-lg-3 col-3 horizon-center">
                            <label class="topic-nomal ">Deadline</label>
                        </div>
                        <div class="col-lg-7 col-6">
                            <input type="number" value="{{$stepData['deadline']}}" id="deadline" name="deadline" class="form-control" placeholder="6" onchange="deadlineValidate()"> 
                        </div>
                        <div class="col-lg-2 col-3">
                            <label class="topic-nomal horizon-center">Hour(s)</label> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-0"></div>
                        </div>
                        <div class="col-lg-9">
                            <p id="errdeadline" class="err-text"></p>
                        </div>
                    </div> 

                    <div class="row mb-2">
                        <div class="col-lg-3 justify-content-center align-self-center topic-nomal"> Validator Select By</div>
                        <div class="col-lg-3 justify-content-center align-self-center">
                            @if($stepData['typeOfValidator']!="position")
                                <input type="radio" name="selectBy" value="position" onclick="validatorValidate()">  Position
                            @else
                                <input type="radio" name="selectBy" value="position" onclick="validatorValidate()" checked>  Position
                            @endif
                        </div>
                        <div class="col-lg-5">
                            <select class="form-control" name="position" id="selectPosition" style="display:none">
                                @foreach($userPosition as $p)
                                    @php $val = $stepData['validator'] @endphp
                                    @if($stepData['typeOfValidator']=="position" && $val[0]==$p->position_Id)
                                        <option value="{{$p->position_Id}}" selected>{{$p->position_Name}}</option>
                                    @else
                                        <option value="{{$p->position_Id}}">{{$p->position_Name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>  
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-2 justify-content-center align-self-center">
                            @if($stepData['typeOfValidator']!="name")
                                <input type="radio" name="selectBy" value="search" onclick="validatorValidate()">  Person
                            @else
                                <input type="radio" name="selectBy" value="search" onclick="validatorValidate()" checked>  Person
                            @endif
                            </div>
                        <div class="col-lg-3">
                            <input style="display:none" class="form-control mr-sm-2" id="search" name ="search" type="search" onkeyup="find()" placeholder="Search" aria-label="Search">
                        </div>
                        <div class="col-lg-3">
                            <select class="form-control" id="position" style="display:none" onchange="searchPosition()">
                                <option id="defaultNull" disabled selected value="notSelect">Position :</option>
                                @foreach($userPosition as $p)
                                    <option value="{{$p->position_Id}}" id="{{$p->position_Id}}">{{$p->position_Name}}</option>
                                @endforeach
                            </select>
                        </div>  
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group mb-0"></div>
                        </div>
                        <div class="col-lg-9">
                            <p id="errvalidator" class="err-text"></p>
                        </div>
                    </div> 
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <div class=" table-responsive" id="listValidator" style="display:none">
                                <table class="table table-list-search " >
                                    <thead>
                                        <tr>
                                            <th>
                                            </th>
                                            <th class="center">Name</th>
                                            <th class="center">Surname</th>
                                            <th class="center">Email</th>
                                            <th class="center">Position</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTable">
                                    </tbody>
                                </table>
                                <p id="notFoundErr" style="text-align:center"></p>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <input type="hidden" name="step" value={{$step}}>
            <div class="row mb-2">
                <div class="col-lg-8 col-xs-12 text-center block-center">
                    @if(Session::has('FlowCreate') && $step!=$flow['numberOfStep'])
                        <button type="button" class="btn btn-success mt-3" onClick="validateAndSubmit()">Next</button>
                    @elseif(Session::has('FlowCreate') && $step==$flow['numberOfStep'])    
                        <button type="button" class="btn btn-success mt-3" onClick="validateAndSubmit()">Finish</button>
                    @else
                        <button class="btn btn-danger mt-3" type="button" data-toggle="modal" data-target="#cancelCreateFlowModalCenter">Cancel</button>
                        <!-- Modal -->
                        <div class="modal fade" id="cancelCreateFlowModalCenter" tabindex="-1" role="dialog" aria-labelledby="cancelCreateFlowModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        Do you want to leave this page?<br>
                                        The system does not save your actions.
                                        <div>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                            <button type="button" class="btn btn-secondary" onclick="notDelSession();window.location='EditFlow?flow_Id={{$flow['flow_Id']}}#flowStep'">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>               
                        <button type="button" class="btn btn-success mt-3" onClick="validateAndSubmit()">Save</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    @if($stepData['typeOfValidator']=="name")
        <script>
            var val = '<?= json_encode($stepData['validator']) ?>' ;
            hiddenn(1);
            showSelectVal(val);
            console.log(val);
        </script> 
    @elseif($stepData['typeOfValidator']=="position")
        <script>
            hiddenn(0);
        </script> 
    @endif
@endsection