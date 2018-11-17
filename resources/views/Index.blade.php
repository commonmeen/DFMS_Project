<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link type="text/css" href="css/style.css" rel="stylesheet">
    @yield('script')
    @yield('head')
    <title>@yield('title')</title>
    <style>
        .card{
            height: 100%;
        }
    </style>
</head>
<body>
    {{-- nav --}}
    <nav class="navbar navbar-expand-lg navbar-light nav-color sticky-top">
        <div class="container">
        <a class="navbar-brand" href="/">DFMS</a>
        <a href="Login" class="btn btn-light mb-0">Login</a>
    </nav>      

    {{-- body --}}
    <div class="container mb-5">
        <div class="row mt-5">
            <div class="col-lg-6 col-12 horizon-center test ">
                <h2 class="index-topic">DFMS</h2>
                <p class="index-des">Document Flow Management System is made for the personal in organization to easily submit document and easily track about document in the process.</p>
                <p class="index-des-1 mb-4">In addition, Our application can made approver comfortable for approving the documents. It’s resolve the problem that they use long time for processing document to approve</p>
            </div>
            <div class="col-lg-6 col-12 d-none d-md-block">
                <img src="../pic/poster.png" alt="" class="poster-img">
            </div>
            <div class="col-lg-6 col-12 d-sm-none">
                <br><br><br>
            </div>
        </div>
        
        
        
        <div class="row mt-4">
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="../pic/document.png" class="card-img-top index-img-card">
                    <div class="card-body">
                        <h5 class="index-title">Document List</h5>
                        <p class="card-text">Document arrangement in the order of different document types for approval. You can create and edit the information in your document, but the format has to follow the document template that you use.</p>
                    </div>
                </div>  
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="../pic/template.png" class="card-img-top index-img-card">
                    <div class="card-body">
                        <h5 class="index-title">Document Template</h5>
                        <p class="card-text">The management of document form. You can create the template to provide the user an accurate document form.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="../pic/submit.png" class="card-img-top index-img-card">
                    <div class="card-body">
                        <h5 class="index-title">Document Submission</h5>
                        <p class="card-text">The management of document submission. Attach and send the document in the provided Process flow.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-2 mb-4"></div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="../pic/process.png" class="card-img-top index-img-card">
                    <div class="card-body">
                        <h5 class="index-title">Process Flow</h5>
                        <p class="card-text">Determining the steps of process document to be the document sending format which you can adapt to your own work effectively.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card">
                    <img src="../pic/approved.png" class="card-img-top index-img-card">
                    <div class="card-body">
                        <h5 class="index-title">Approve / Reject</h5>
                        <p class="card-text">Approving the document which is sent to you by the user. You can approve the document when it is correct or reject the document when it is incorrect.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 mb-4"></div>
        </div>
    </div>
        

    {{-- footer --}}
    <footer class="footer">
        <img src="../pic/sit.png" alt="" class="footer-img">
    </footer>
    
</body>
</html>