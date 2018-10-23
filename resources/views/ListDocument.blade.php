@extends('layout.Navbar')
@section('user')
    {{Session::get('UserLogin')->user_Name}}
    {{Session::get('UserLogin')->user_Surname}}
@endsection
@section('script')
    <!-- Data table -->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready( function () {
            $('#sent-page').DataTable();
        } );

        $(document).ready( function () {
            $('#drafts-page').DataTable();
        });

        $(document).ready( function () {
            $('#trush-page').DataTable();
        });
    </script>
@endsection
@section('content')
    <div class="container">
        <br>
        <div class="row">
            {{--  Large screen  --}}
            <div class="col-12 col-sm-5 col-md-5 col-lg-6 d-none d-sm-block">   
                <p class="topic">Your Document List</p>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 d-none d-sm-block">
                <a role="button" class="btn btn-success float-right" href="GetTemplateForDocument">New Document</a>
            </div>

            {{--  Small screen  --}}
            <div class="col-12 d-sm-none center">   
                <p class="topic">Your Document List</p>
            </div>
            <div class="col-12 d-sm-none ">
                <a role="button" class="btn btn-block btn-success float-right" href="GetTemplateForDocument">New Document</a>
            </div>
            
        </div>
        <ul class="nav nav-tabs " role="tablist">
            <li class="nav-item">
            <a class="nav-link active toggle-nav" data-toggle="tab" href="#sent">Sent</a>
            </li>
            <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#drafts">Drafts</a>
            </li>
            <li class="nav-item">
            <a class="nav-link toggle-nav" data-toggle="tab" href="#trush">Trush</a>
            </li>
        </ul>

        @php $sentDoc = array(); $draftsDoc = array(); $deleteDoc = array(); @endphp
        @foreach($allDocument as $document)
            @if($document['status']=="used")
                @php array_push($sentDoc,$document) @endphp
            @elseif($document['status']=="unuse")
                @php array_push($draftsDoc,$document) @endphp
            @elseif($document['status']=="delete")
                @php array_push($deleteDoc,$document) @endphp
            @endif
        @endforeach

        <div class="tab-content">
            {{--  Sent  --}}
            <div id="sent" class="container tab-pane active"><br>
                <table class="table table-list-search table-hover" id="sent-page">
                    <thead>
                        <tr class="center">
                            <th>Docutment name</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sentDoc as $doc)
                            <tr onclick="window.location='DocumentDetail?doc_Id={{$doc['document_Id']}}';">
                                <td><div class="text-over">{{$doc['document_Name']}}</div></td>
                                <td class="center">{{$doc['updated_at']}}</td>
                            </tr>
                        @endforeach        
                    </tbody>
                </table>
            </div>

            {{--  Drafts  --}}
            <div id="drafts" class="container tab-pane fade"><br>
                <table class="table table-list-search table-hover" id="drafts-page">   
                    <thead>
                        <tr class="center">
                            <th>Docutment name</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($draftsDoc as $doc)
                            <tr onclick="window.location='DocumentDetail?doc_Id={{$doc['document_Id']}}';">
                                <td><div class="text-over">{{$doc['document_Name']}}</div></td>
                                <td class="center">{{$doc['updated_at']}}</td>
                            </tr>
                        @endforeach        
                    </tbody>
                </table>
            </div>

            {{--  Trush  --}}
            <div id="trush" class="container tab-pane fade"><br>
                <table class="table table-list-search table-hover" id="trush-page">   
                    <thead>
                        <tr class="center">
                            <th>Docutment name</th>
                            <th>Last Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deleteDoc as $doc)
                            <tr onclick="window.location='DocumentDetail?doc_Id={{$doc['document_Id']}}';">
                                <td><div class="text-over">{{$doc['document_Name']}}</div></td>
                                <td class="center">{{$doc['updated_at']}}</td>
                            </tr>
                        @endforeach        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection  