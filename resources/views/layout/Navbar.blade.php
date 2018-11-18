<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-3.3.1.js"  crossorigin="anonymous"></script>
    <script src="js/popper.min.js"  crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"  crossorigin="anonymous"></script>
    <link rel='shortcut icon' type='image/x-icon' href='../pic/header_logo.png' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link type="text/css" href="css/style.css" rel="stylesheet">
    @yield('script')
    @yield('head')
    <title>@yield('title')</title>
    <style>
        .noti-num-small {
          width:17px;
          height:17px;
          line-height:1;
          margin-bottom : 14px;
          margin-left : -90px;
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
      .unread {
        font-size: 15pt;
        border-bottom : solid 1px #ccc;
        white-space: initial;
        text-overflow: ellipsis;
        height: fit-content;
      }
      .img-noti{
        width: 15%;
        margin-right: 2%
      }
      .dropdown-menu.notiDetail{
        width: 350px !important;
        height: 500px;
        overflow-y: scroll;
      }
    </style>
    <script>
      function changeNotiStatus(notiId){
        data = {noti_Id:notiId};
        $.ajax({
          type: "get",
          data: data,
          url: "ReadNoti",
          cache    : false,
          success:function(data){}
        });
      }
      function getNoti(){
        $.ajax({
          type: "get",
          url: "NotiRequest",
          cache    : false,
          success:function(data){
            document.getElementById("notiDetail").innerHTML = "" ;
            document.getElementById("notiDetailMobile").innerHTML = "" ;
            for(i=data.noti.length-1,j=data.noti.length-1; i>=0 ;i--){

              d = new Date(data.noti[i].created_at);
                var months = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];
                var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                var stringDate = days[d.getDay()]+", "+d.getDate()+" "+months[d.getMonth()];
                  
              if(data.noti[i].status == "unread"){
                if(data.noti[i].header == "Process Successful"){
                  document.getElementById("notiDetail").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/success.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                  document.getElementById("notiDetailMobile").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/success.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                
                }
                else if(data.noti[i].header == "Waiting for approval"){
                  document.getElementById("notiDetail").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/approve.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                  document.getElementById("notiDetailMobile").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/approve.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                
                }
                else if(data.noti[i].header == "Process was rejected"){
                  document.getElementById("notiDetail").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/reject.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                  document.getElementById("notiDetailMobile").innerHTML += "<a class='dropdown-item disable unread' onclick=changeNotiStatus('"+data.noti[i].notification_Id+"') href='"+data.noti[i].link+"'><img class='img-noti' src='../pic/reject.png'><strong>"+data.noti[i].detail+"</strong><br>"+stringDate+"</a>"
                
                }
              } 
            }
            if(data.count > 0){
              document.getElementById("countNoti").style.opacity = 1;
              document.getElementById("countNoti").innerHTML = data.count ;
              document.getElementById("countNotiMobile").innerHTML = data.count ;
              document.getElementById("countNotiMobile").style.opacity = 1;
              document.getElementById("countNotiMobile").style.fontSize = '18px' ;
              document.getElementById("countNoti").style.fontSize = '18px' ;
              if(data.count >= 10){
                document.getElementById("countNoti").style.fontSize = '16px' ;
                document.getElementById("countNotiMobile").style.fontSize = '16px' ;
              }
              if(data.count > 99){
                document.getElementById("countNoti").innerHTML = '99+' ;
                document.getElementById("countNotiMobile").innerHTML = '99+' ;
              }
            } else {
              document.getElementById("countNoti").style.opacity = 0;
              document.getElementById("countNotiMobile").style.opacity = 0;
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
        <a class="navbar-brand" href="/"><img src="../pic/logo.png" alt="" width="100"></a>
        {{-- Small screen --}}
        <a class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" id="bellMobile"><img class="d-md-block d-lg-none" src="pic/notification.png"></a>
        <span class="d-md-block d-lg-none noti-num-small" id="countNotiMobile"></span>
        <div class="dropdown-menu notiDetail" id="notiDetailMobile"></div>
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
          {{-- Large screen --}}
        <span class="d-none d-sm-block noti-num" id="countNoti"></span>
        <div class="nav-item dropdown">
          <a class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" id="bell"><img class="d-none d-sm-block" src="pic/notification.png"></a>
          <div class="dropdown-menu notiDetail" id="notiDetail"></div>
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