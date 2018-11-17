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

    <style>
            .error-head{
                font-size: 40pt;
                font-weight: bold;
                color: #FFF;
            }
            .error-content{
                font-size: 30pt;
                color: #FFF;
            }
            .block{
                position: absolute;
                top: 50%;
                left: 50%;
                margin-right: -50%;
                transform: translate(-50%, -50%);
            }
            .error-img{
                width: 30%;
                position: fixed;
                z-index: -1;
            }
            body{
                background-color: #2A9EBF;
            }
            img.vert-move {
                -webkit-animation: mover 2s infinite  alternate;
                animation: mover 2s infinite  alternate;
            }
            img.vert-move {
                -webkit-animation: mover 2s infinite  alternate;
                animation: mover 2s infinite  alternate;
            }
            @-webkit-keyframes mover {
                0% { transform: translateY(0); }
                100% { transform: translateY(-10px); }
            }
            @keyframes mover {
                0% { transform: translateY(0); }
                100% { transform: translateY(-10px); }
            }
            a:link,a:visited,a:active,a:hover{
                color: #FFF;
                text-decoration: none;
            }
        </style>
</head>
<body>
    <div class="container">
        <div class="block">
            <p class="error-head center mb-0">Ooops! {{$errorHeader}}</p>
            <p class="error-content center mb-0">{{$errorContent}}</p>
            <p class="error-content center"><a href="/"><< back to home page</a></p>
            <div class="row">
                <div class="col-10"></div>
                <div class="col-2"><img src="../pic/errorlogo.png" alt="" class="error-img vert-move"></div>
            </div>
        </div> 
    </div>
</body>
</html>