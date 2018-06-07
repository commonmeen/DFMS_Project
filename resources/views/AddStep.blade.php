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
                for(var i=0; i<response.searchAll.length ; i++){
                    document.getElementById('userTable').innerHTML += "<tr><td><div class='ckbox'>"+
                    "<input type='checkbox' name='validator[]'"+
                    "value='"+response.searchAll[i].user_Id+
                    "' id='"+response.searchAll[i].user_Id+
                    "'></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+
                    "</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+
                    "</td><td id='user_Email'>"+response.searchAll[i].user_Email+
                    "</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
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
                for(var i=0; i<response.searchAll.length ; i++){
                    document.getElementById('userTable').innerHTML += "<tr><td><div class='ckbox'>"+
                    "<input type='checkbox' name='validator[]'"+
                    "value='"+response.searchAll[i].user_Id+
                    "' id='"+response.searchAll[i].user_Id+
                    "'></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+
                    "</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+
                    "</td><td id='user_Email'>"+response.searchAll[i].user_Email+
                    "</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
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
                    "<input type='checkbox' name='validator[]'"+
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

    function validateAndSubmit(){
        var title = titleValidate();
        var verify = verifyValidate();
        var deadline = deadlineValidate();
        var validator = validatorValidate()
        if(title&&deadline&&verify&&validator){
            document.getElementById('step').submit();
        }
    }

</script>
@endsection

@section('content')
    <div class="container content">
        @if($step!=null)
        {{-- Large Screen --}}
        <div class="d-none d-sm-block">
            <div class="row">
                <div class="col">
                <h3>Create Flow  : "{{$flow['flow_Name']}}"</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="btn btn-outline-secondary" href="#" role="button" >Detail flow</a>
                    <a class="btn btn-outline-secondary" href="#" role="button" >Select template</a>
                    @for($i=1;$i<=$flow['numberOfStep'];$i++)
                        @if($step==$i)
                            <a class="btn btn-secondary" href="#" role="button" >Step {{$i}}</a>
                        @else
                            <a class="btn btn-outline-secondary" href="" role="button">Step {{$i}}</a>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
        
    {{-- Small Screen --}}
        <div class="d-sm-none">
            <div class="row">
                <div class="col">
                    <span class="top-menu text-center">Create Flow : "{{$flow['flow_Name']}}"</span> 
                    <div class="dropbown d-inline ml-5">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" href="#">Detail flow</button>
                            <button class="dropdown-item" href="" disabled>Select template</button>
                            @for($i=1;$i<=$flow['numberOfStep'];$i++)
                            @if($step==$i)
                                <button class="dropdown-item" href="#"  >Step {{$i}}</button>
                            @else
                                <button class="dropdown-item" href="" >Step {{$i}}</button>
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
                    <div class="col">
                    <h3>Edit Flow  : "{{$flow['flow_Name']}}"</h3>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-2">
                    </div>
                    <div class="col">
                        <h5>Step  : {{$stepData['step_Title']}}</h5>
                    </div>
                </div>
            </div>
            <br><br>
        @endif

        <form action="AddStep" id="step">
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Name</label>
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
                                    <p id="errtitle" class="verifyText"></p>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Verify By</label>
                            </div>
                            
                            <label class="col-lg-3 radio-inline">
                                @if($stepData['typeOfVerify']!="allow")
                                    <input type="radio" name="type" value="allow" id="allow"> Allow
                                @else
                                    <input type="radio" name="type" value="allow" id="allow" checked> Allow
                                @endif 
                            </label>
                            <label class="col-lg-3 radio-inline">
                                @if($stepData['typeOfVerify']!="password")
                                    <input type="radio" name="type" value="password" id="password"> Password
                                @else
                                    <input type="radio" name="type" value="password" id="password" checked> Password
                                @endif 
                            </label>
                            <label class="col-lg-3 radio-inline">
                                @if($stepData['typeOfVerify']!="otp")
                                    <input type="radio" name="type" value="otp" id="OTP"> OTP
                                @else
                                    <input type="radio" name="type" value="otp" id="OTP" checked> OTP
                                @endif 
                            </label>                                    
                        </div>
                        <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-0"></div>
                                </div>
                                <div class="col-lg-9">
                                    <p id="errverify" class="verifyText"></p>
                                </div>
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Deadline</label>
                            </div>
                            <div class="col-lg-7">
                                <input type="number" value="{{$stepData['deadline']}}" id="deadline" name="deadline" class="form-control" placeholder="6" onkeyup="deadlineValidate()"> 
                            </div>
                            <div class="col-lg-2">
                                Hour(s)
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group mb-0"></div>
                                </div>
                                <div class="col-lg-9">
                                    <p id="errdeadline" class="verifyText"></p>
                                </div>
                        </div> 

                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center"> Validator Select By</div>
                            <div class="col-lg-2 justify-content-center align-self-center">
                                @if($stepData['typeOfValidator']!="position")
                                    <input type="radio" name="selectBy" value="position" onclick="validatorValidate()">  Position
                                @else
                                    <input type="radio" name="selectBy" value="position" onclick="validatorValidate()" checked>  Position
                                @endif
                            </div>
                            <div class="col-lg-7">
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

                        <div class="row mb-3">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-2 justify-content-center align-self-center">
                                @if($stepData['typeOfValidator']!="name")
                                    <input type="radio" name="selectBy" value="search" onclick="validatorValidate()">  Person
                                @else
                                    <input type="radio" name="selectBy" value="search" onclick="validatorValidate()" checked>  Person
                                @endif
                                </div>
                            <div class="col-lg-4">
                                <input style="display:none" class="form-control mr-sm-2" id="search" name ="search" type="search" onkeyup="find()" placeholder="Search" aria-label="Search">
                            </div>
                            <div class="col-lg-3">
                                <select class="form-control" id="position" style="display:none" onchange="searchPosition()">
                                    <option id="defaultNull" disabled selected value="notSelect">Position :</option>
                                    @foreach($userPosition as $p)
                                        <option value="{{$p->position_Id}}">{{$p->position_Name}}</option>
                                    @endforeach
                                </select>
                            </div>  
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group mb-0"></div>
                            </div>
                            <div class="col-lg-9">
                                <p id="errvalidator" class="verifyText"></p>
                            </div>
                        </div> 
                        <div class=" table-responsive" id="listValidator" style="display:none">
                            <table class="table table-list-search " >
                                <thead>
                                    <tr>
                                        <th>
                                            {{-- <div class="ckbox">
                                                <input type="checkbox" id="checkboxAll">
                                            </div> --}}
                                        </th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>
                                <tbody id="userTable">
                                </tbody>
                            </table>   
                        </div>
                    </div>
                <div class="col-lg-2"></div>
            </div><br>
            <input type="hidden" name="step" value={{$step}}>
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 text-center">
                        @if($stepData == null)
                        <button type="button" class="btn btn-success m-2" onClick="validateAndSubmit()">Next</button>
                        @else
                        <a class="btn btn-danger m-2" href="FlowDetail?id={{$stepData['flow_Id']}}">Cancel</a>
                        <button type="button" class="btn btn-success m-2" onClick="validateAndSubmit()">Save</button>
                        @endif
                    </div>
                <div class="col-lg-2"></div>
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