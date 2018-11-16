@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<link rel="stylesheet" href="css/cloudflare-animate.min.css">
<link rel="stylesheet" href="css/jsdelivr-animate.min.css">
<script>
    function versionClick(version,countVer){
        if(version != -1){
            document.getElementById('VerDoc').innerHTML = " (Version "+version+")";
            document.getElementById('VerDocMobile').innerHTML = " (Version "+version+")";
            document.getElementById('DeleteDocButton').hidden = true ;
            document.getElementById('DeleteDocButtonMobile').hidden = true ;
            document.getElementById('EditDocButton').hidden = true ;
            document.getElementById('EditDocButtonMobile').hidden = true ;
            for(countVer;countVer>0;countVer--){
                document.getElementById('docDataVer'+countVer).hidden = true ;
            }
            document.getElementById('docData').hidden = true;
            document.getElementById('docDataVer'+version).hidden = false;
        } else {
            document.getElementById('VerDoc').innerHTML = "";
            document.getElementById('VerDocMobile').innerHTML = "";
            document.getElementById('docData').hidden = false;
            document.getElementById('DeleteDocButton').hidden = false ;
            document.getElementById('DeleteDocButtonMobile').hidden = false ;
            document.getElementById('EditDocButton').hidden = false ;
            document.getElementById('EditDocButtonMobile').hidden = false ;
            for(countVer;countVer>0;countVer--){
                document.getElementById('docDataVer'+countVer).hidden = true ;
            }
        }
    }
    function checkPassword(id){
        var password = document.getElementById('deletePassword').value;
        var pass = {password:password};
        var data = {document_Id:id};
        $.ajax({
            type     : "GET",
            url      : "ChkPassword",
            data     : pass,
            cache    : false,
            success  : function(response){
                if(response.status==false){
                    document.getElementById('errDeletePassword').innerHTML = "Incorrect password please try again";
                }else{
                    $.ajax({
                        type     : "GET",
                        url      : "DeleteDocument",
                        data     : data,
                        cache    : false,
                        success  : function(response){
                            window.location='/ListDocument';
                        }
                    });
                    $('#deleteDocumentModalCenter').modal('hide');
                }
            }
        });
    }
</script>
@endsection
@section('content')   
    <div class="container content">

        {{--  Success alert  --}}
        @if(session('alertStatus') == "Success")
            <div class="alert alert-success" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Create Success! </strong>
                You have successfully create the document.
            </div>
            <script>
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
            </script>

        {{--  Edit Success alert  --}}
        @elseif(session('alertStatus') == "EditSuccess")
            <div class="alert alert-success" id="success-alert">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <strong>Edit Success! </strong>
                You have successfully edit the document.
            </div>
            <script>
            $("#success-alert").fadeTo(5000, 500).slideUp(500, function(){
                $("#success-alert").slideUp(500);
            });
            </script>
        @endif
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-sm-6 col-lg-6 d-none d-sm-block">
                <p class="topic" id="NameDoc">Document : {{$document['document_Name']}}<span id="VerDoc"></span></p>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic" id="NameDocMobile">Document : {{$document['document_Name']}}<span id="VerDocMobile"></span></p>
            </div>
            @if($document['status']=='unuse')
            {{--  Large screen  --}}
            <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <a role="button" id="EditDocButton" class="btn btn-primary float-right" href="EditDocument?doc_Id={{$document['document_Id']}}">Edit Document</a>
            </div>
            <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <button id="DeleteDocButton" class="btn btn-danger float-left" type="button" data-toggle="modal" data-target="#deleteDocumentModalCenter">Delete Document</button>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 d-sm-none">
                <button id="DeleteDocButtonMobile" class="btn btn-block btn-danger" type="button" data-toggle="modal" data-target="#deleteDocumentModalCenter">Delete Document</button>
            </div>
            <div class="col-12 d-sm-none">
                <a role="button" id="EditDocButtonMobile" class="btn btn-block btn-primary float-right" href="EditDocument?doc_Id={{$document['document_Id']}}">Edit Document </a>
            </div>
            @endif

            {{--  Delete Document  --}}
            <!-- Modal -->
            <div class="modal fade" id="deleteDocumentModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <p class="modal-title alert-title">
                            This deletion will not restore the document. Are you sure you want to delete "{{$document['document_Name']}}" document?
                        </p>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 form-group mb-0">
                                    <label class="col-form-labelr align-self-center">Password</label>
                                </div>
                                <div class="col-lg-9">
                                    <input type="password" name="password" id="deletePassword" class="form-control">
                                </div>
                                <div class="col-lg-3"></div>
                                <div class="col-lg-9">
                                    <div id="errDeletePassword" class="err-text"></div> 
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                            <button type="button" class="btn btn-secondary" onclick="checkPassword('{{$document['document_Id']}}')">Yes</button>   
                        </div>
                    </div>
                </div>    
            </div>
        </div> 
        <hr>
        <div class="row">
            @if(count($previous_ver)>0)
            <div class="col-lg-4 col-12">
                <b><p class="center mb-1">Old Version</p></b>
                <table class="table table-hover mb-0">
                    @for($i = count($previous_ver)-1,$j =1 ; $i>=0 ; $i--,$j++)
                    <tr onclick="versionClick({{$j}},{{count($previous_ver)}})" style="border-bottom:1px solid;border-color:rgba(0,0,0,.1)">
                        <td class="center">Version {{$j}}</td>
                        <td class="center">{{$previous_ver[$i]['updated_at']}}</td>
                    </tr>
                    @endfor
                </table>
                <a class='dropdown-item disable center' onclick='versionClick(-1,{{count($previous_ver)}})'>Current Version</a>
            </div>
            <div class="col-lg-8 col-12 block-center">
            @else
            <div class="col-lg-10 col-12 block-center">
            @endif
                <div class="doc-block animated fadeInUp delay-3s" id="docData">
                    <h5><center>{{$document['document_Name']}}</center></h5>
                    <br>
                    @foreach($document['data'] as $detail)
                        <span class='topic-nomal'>{{$detail['title']}} : </span> 
                        @if(is_array($detail['detail']))
                            @foreach($detail['detail'] as $dataInDetail)
                                @if($dataInDetail != array_last($detail['detail']))
                                    {{$dataInDetail}}, 
                                @elseif(count($detail['detail'])>1)
                                    and {{$dataInDetail}}
                                @else
                                    {{$dataInDetail}}
                                @endif
                            @endforeach
                        @else
                            {{$detail['detail']}} <br>
                        @endif
                    @endforeach
                </div>
                @for($i = count($previous_ver)-1,$j =1 ; $i>=0 ; $i--,$j++)
                    <div class="doc-block animated fadeInUp delay-3s" id="docDataVer{{$j}}" hidden>
                    <h5><center>{{$previous_ver[$i]['document_Name']}}</center></h5>
                    <br>
                    @foreach($previous_ver[$i]['data'] as $detail)
                        <span class='topic-nomal'>{{$detail['title']}} : </span> 
                        @if(is_array($detail['detail']))
                            @foreach($detail['detail'] as $dataInDetail)
                                @if($dataInDetail != array_last($detail['detail']))
                                    {{$dataInDetail}}, 
                                @elseif(count($detail['detail'])>1)
                                    and {{$dataInDetail}}
                                @else
                                    {{$dataInDetail}}
                                @endif
                            @endforeach
                        @else
                            {{$detail['detail']}} <br>
                        @endif
                    @endforeach
                </div>
                @endfor
            </div>
        </div>
    </div>
@endsection