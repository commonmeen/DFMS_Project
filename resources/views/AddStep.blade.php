@extends('layout.navbar')
@section('script')
<script type="text/javascript">
    function find(){
        var formData = {
            search : document.getElementById("search").value
        };
        $.ajax({
            type     : "GET",
            url      : "SearchUser",
            data     : formData,
            cache    : false,
            success  : function(response){
                document.getElementById('u').innerHTML = "" ;
                for(var i=0; i<response.searchAll.length ; i++){
                    document.getElementById('u').innerHTML += "<tr><td><div class='ckbox'><input type='checkbox' name='validator[]' value='"+response.searchAll[i].user_Id+"' id='"+response.searchAll[i].user_Id+"'></div> </td><td id='user_Name'>"+response.searchAll[i].user_Name+"</td><td id='user_Surname'>"+response.searchAll[i].user_Surname+"</td><td id='user_Email'>"+response.searchAll[i].user_Email+"</td><td id='user_Position'>"+response.searchAll[i].user_Position+"</td></tr>"
                }
            }
        });
    }
</script>
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
                    {{-- @for($i=1;$i<=$Flow['numberOfStep'];$i++)
                    <a class="btn btn-outline-secondary" href="#" role="button" >Step {{$i}}</a>
                    @endfor --}}
                </div>
            </div>
        </div>
        
    {{-- Small Screen --}}
        <div class="d-sm-none">
            <div class="row">
                <div class="col">
                    <span class="top-menu">Create Flow</span> 
                    <div class="dropbown d-inline ml-5">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Menu</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <button class="dropdown-item" href="#">Detail flow</button>
                            <button class="dropdown-item" href="" disabled>Select template</button>
                            {{-- @for($i=1;$i<=$Flow['numberOfStep'];$i++)
                            <a class="dropdown-item" href="#">Step {{$i}}</a>
                            @endfor --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <form action="AddStep">
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12">
                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Name</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="text" name="title" class="form-control" placeholder="Example">
                            </div>
                        </div>
                                        
                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Type of Verify</label>
                            </div>
                                <label class="col-lg-3 radio-inline">
                                    <input type="radio" name="type" value="allow"> Allow
                                </label>
                                <label class="col-lg-3 radio-inline">
                                    <input type="radio" name="type" value="password"> Password
                                </label>
                                <label class="col-lg-3 radio-inline">
                                    <input type="radio" name="type" value="otp"> OTP
                                </label>                                     
                        </div>
                    
                        <div class="row mb-3">
                            <div class="col-lg-3 justify-content-center align-self-center">
                                <label class="">Deadline</label>
                            </div>
                            <div class="col-lg-9">
                                <input type="number"  name="deadline" class="form-control" placeholder="1 Hour(s)"></input>  
                            </div>
                        </div> 
                      
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <input class="form-control mr-sm-2" id="search" name ="search" type="search" onkeyup="find()" placeholder="Search" aria-label="Search">
                            </div>
                            <div class="col-lg-2 mb-3">
                                <label for="selectPosition">Position</label>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <select class="form-control" id="selectPosition" >
                                    @foreach($userPosition as $p)
                                        <option>{{$p[0]}}</option>
                                    @endforeach
                                </select>
                            </div>  
                        </div>

                        <div class=" table-responsive">
                            <table class="table table-list-search " >
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="ckbox">
                                                <input type="checkbox" id="checkboxAll">
                                            </div>
                                        </th>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Email</th>
                                        <th>Position</th>
                                    </tr>
                                </thead>

                                {{-- @foreach($userList as $user) --}}
                                <tbody id="u">
                                </tbody>
                                {{-- @endforeach --}}
                            </table>   
                        </div>
                    </div>

                <div class="col-lg-2"></div>
            </div><br>
            <div class="row">
                <div class="col-lg-2"></div>
                    <div class="col-lg-8 col-xs-12 text-center">
                        <input type="submit" value="Next" class="btn btn-success m-2">
                    </div>
                <div class="col-lg-2"></div>
            </div>
        </form>

@endsection