@extends('layout.Navbar') 
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
<script>
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
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-sm-6 col-lg-9 d-none d-sm-block">
                <p class="topic">Document : {{$document['document_Name']}}</p>
            </div>
            {{-- <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <a role="button" class="btn btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div> --}}
            {{--  Small screen  --}}
            <div class="col-12 center d-sm-none">
                <p class="topic">Document : {{$document['document_Name']}}</p>
            </div>
            {{-- <div class="col-12 d-sm-none">
                <a role="button" class="btn btn-block btn-primary float-right" href="EditFlow?flow_Id={{$flow['flow_Id']}}">Edit</a>
            </div> --}}


            @if($document['status']=='unuse')
            {{--  Large screen  --}}
            <div class="col-sm-3 col-lg-3 d-none d-sm-block">
                <button class="btn btn-danger float-left" type="button" data-toggle="modal" data-target="#deleteDocumentModalCenter">Delete Document</button>
            </div>
            {{--  Small screen  --}}
            <div class="col-12 d-sm-none">
                <button class="btn btn-block btn-danger" type="button" data-toggle="modal" data-target="#deleteDocumentModalCenter">Delete Document</button>
            </div>
            @endif

            {{--  Delete Document  --}}
            <!-- Modal -->
            <div class="modal fade" id="deleteDocumentModalCenter" tabindex="-1" role="dialog" aria-labelledby="deleteDocumentModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <p class="modal-title alert-title">
                            Do you want to delete "{{$document['document_Name']}}" template?
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
        <div class="col-lg-10 col-12 block-center">
            <div class="doc-block">
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
        </div>

    </div>
@endsection