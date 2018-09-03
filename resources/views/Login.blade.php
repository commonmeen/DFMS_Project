<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link type="text/css" href="css/style.css" rel="stylesheet">
    <link rel="stylesheet/scss" type="text/scss" href="css/login.scss">
    <title>Document</title>
    <style>
            .login-center{
                position: absolute;
                top:0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                width: 100%;
                height: 100px;
            }
            .block-width{
                width: 60%;
            }
            .ball {
                position: absolute;
                border-radius: 100%;
                
              }
                       
    </style>
    

</head>
<body class="bg-color">
    <div class="container"> 
        <div class="row">

            <div class="col-lg-6 col-12 block-center block-top animated flipInX delay-5s">
                <form name="loginform" id="loginform" method="POST" action="">
                    <div class="row mb-2">
                        <div class="col-lg-12 center">
                            <label class="topic-login animated pulse infinite delay-3s">Sign in</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <input type="text" class="form-control" placeholder="Username" id="username" onkeyup="validateUser()">
                        </div>
                        <div class="col-lg-12">
                            <div id="err-username"></div>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <input type="password" class="form-control" placeholder="Password" id="password" onkeyup="validatePassword()">
                        </div>
                        <div class="col-lg-12">
                            <div id="err-password"></div>
                        </div>
                    </div>
                </form>
                <div class="row mb-2">
                    <div class="col-lg-12 block-center">
                        <button class="btn btn-block btn-success" onclick="submit()">Login</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Validate form
        function submit(){
            var user = validateUser();
            var pass = validatePassword();
            if(user&&pass == true){
                document.getElementById('loginform').submit();
                console.log('Login pass')
            }
            else
                console.log('Login false');
        }

        function validateUser(){
            user = document.getElementById('username').value;
            if(user == ""){
                document.getElementById('err-username').innerHTML = "Username is required";
                document.getElementById('err-username').style.color = "red";
                document.getElementById('err-username').style.fontWeight = "bold";
                console.log('User : False');
                return false;
            }
            else
                document.getElementById('err-username').innerHTML = '';
                console.log('User : True');
                return true;
        }

        function validatePassword(){
            pass = document.getElementById('password').value;
            if(pass == ""){
                document.getElementById('err-password').innerHTML = "Password is required";
                document.getElementById('err-password').style.color = "red";
                document.getElementById('err-password').style.fontWeight = "bold";
                console.log('Pass : False');
                return false;
            }
            else
                document.getElementById('err-password').innerHTML = '';
                console.log('Pass : True');
                return true;
        }






        // Some random colors
{{--  const colors = ["#3CC157", "#EE4266", "#1B1B1B", "#FCBC0F", "#F85F36" ,"#FFF"];
const numBalls = 50;
const balls = [];

for (let i = 0; i < numBalls; i++) {
  let ball = document.createElement("div");
  ball.classList.add("ball");
  ball.style.background = colors[Math.floor(Math.random() * colors.length)];
  ball.style.left = `${Math.floor(Math.random() * 100)}vw`;
  ball.style.top = `${Math.floor(Math.random() * 100)}vh`;
  ball.style.transform = `scale(${Math.random()})`;
  ball.style.width = `${Math.random()}em`;
  ball.style.height = ball.style.width;
  
  balls.push(ball);
  document.body.append(ball);
}

// Keyframes
balls.forEach((el, i, ra) => {
  let to = {
    x: Math.random() * (i % 2 === 0 ? -11 : 11),
    y: Math.random() * 12
  };

  let anim = el.animate(
    [
      { transform: "translate(0, 0)" },
      { transform: `translate(${to.x}rem, ${to.y}rem)` }
    ],
    {
      duration: (Math.random() + 1) * 2000, // random duration
      direction: "alternate",
      fill: "both",
      iterations: Infinity,
      easing: "ease-in-out"
    }
  );
});

    </script>  
     --}}
</body>
</html>