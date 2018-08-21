<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link type="text/css" href="css/style.css" rel="stylesheet">
    @yield('script')
    @yield('head')
    <title>@yield('title')</title>
</head>
<body>
      <nav class="navbar navbar-expand-lg navbar-light nav-color sticky-top">
        <div class="container">
        <a class="navbar-brand" href="/">DFMS</a>
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
              <a class="nav-link nav-text" href="ListTemplate">Document Template</a>
            </li>
            @endif
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListDocument">Document</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListProcess">Process</a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-text" href="ListVerify">Verify</a>
            </li>
            {{-- @if(Session::get('UserLogin')->user_Role=="manager")
            <li class="nav-item">
              <a class="nav-link" href="Statistic">Statistic</a>
            </li>
            @endif --}}
          </ul>
          <img src="pic/user.png" class="user-pic"> <span class="user-color">@yield('user')</span>
          <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item disable" href="#">Sign out</a>
              </div>
          </div>
        </div>
        </nav>      
    @yield('content')
</body>
</html>