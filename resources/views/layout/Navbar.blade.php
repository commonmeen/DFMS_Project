<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="js/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link type="text/css" href="css/style.css" rel="stylesheet">
    @yield('script')
    @yield('head')
    <title>@yield('title')</title>
    <style>
      .noti-num {
        width:17px;
        height:17px;
        line-height:1;
        margin-bottom : 14px;
        margin-right : -57px;
        background-color: red;
        border-radius: 50%;
        color:#f5f5f5;
        text-align:center;
        box-shadow: 0 0 3px gray;
        font-weight:bold;
        background-position: left top;
        z-index: 5;
        opacity: 0;
      }
    </style>
    <script>
      function getNoti(){
        $.ajax({
          type: "get",
          url: "NotiRequest",
          cache    : false,
          success:function(data){
            console.log(data.noti);
            document.getElementById("notiDetail").innerHTML = "" ;
            for(i=data.noti.length-1; i>=0 ;i--){
              document.getElementById("notiDetail").innerHTML += "<a class='dropdown-item disable' href='http://127.0.0.1:8000"+data.noti[i].link+"'>"+data.noti[i].detail+"</a>"
            }
            if(data.count > 0){
              document.getElementById("countNoti").style.opacity = 1;
              document.getElementById("countNoti").innerHTML = data.count ;
              document.getElementById("countNoti").style.fontSize = '18px' ;
              if(data.count >= 10){
                document.getElementById("countNoti").style.fontSize = '16px' ;
              }
              if(data.count > 99){
                document.getElementById("countNoti").innerHTML = '99+' ;
              }
            } else {
              document.getElementById("countNoti").style.opacity = 0;
            }
          }
        });
      }
      $( document ).ready(function() {
        getNoti();
      });
      setInterval(function(){
        getNoti();
      }, 10000);
    </script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light nav-color sticky-top">
      <div class="container">
        <a class="navbar-brand" href="/">DFMS</a>
        <img class="d-sm-none" src="pic/notification.png">
        <span class="d-sm-none noti-num-small" id=""></span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
              
        <div class="collapse navbar-collapse " id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto ">
            <li class="nav-item">
              <a class="nav-link nav-text" href="/">Home</a>
            </li>
            @if(Session::get('UserLogin')->user_Role=="manager")
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListDocTemplate">Document Template</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListDocument">Document</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListProcess">Document Submission</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListVerify">Approved List</a>
            </li>
          </ul>
        <span class="d-none d-sm-block noti-num" id="countNoti"></span>
        <div class="nav-item dropdown">
          <a class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" id="bell"><img class="d-none d-sm-block" src="pic/notification.png"></a>
          <div class="dropdown-menu" id="notiDetail"></div>
        </div>
        <span class="ml-2 user-color">@yield('user')</span>
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" style="color:#FFF" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item disable" href="Logout">Sign out</a>
          </div>
        </div>
      </div>
    </nav>      
    @yield('content')
    <style>
      .footer {
        left: 0;
        bottom: 0;
        width: 100%;
        background-color: #FFF;
        color: white;
        text-align: center;
        border-top:1px solid #dee2e6;
      }
      .footer-img{
        width: 300px;
      }
    </style>
    <footer class="footer">
      <img src="../pic/sit.png" alt="" class="footer-img">
    </footer>
  </body>
</html>