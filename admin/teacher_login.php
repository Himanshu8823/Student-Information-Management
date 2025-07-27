<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);
include("../connection/connect.php"); // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));

    // SQL query to check if the username and password exist
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch user data
        $user = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the main dashboard or home page
        header("location: index.php");
        exit();
    } else {
        // Error message if username or password is incorrect
        $error = "Invalid username or password!";
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
    <style>
       body, html {
  height: 100%;
  background-repeat: no-repeat;    /*background-image: linear-gradient(rgb(12, 97, 33),rgb(104, 145, 162));*/
  background:black;
    ;
  position: relative;
}#login-box {
  position: absolute;
  top: 20%;
  left: 50%;
  transform: translateX(-50%);
  min-width: 350px;
  margin: 0 auto;
  border: 1px solid black;
  background: rgba(48, 46, 45, 1);
  min-height: 250px;
  padding: 20px;
  z-index: 9999;
  transition: all 0.4s ease; /* Smooth transition for hover effect */
}

#login-box:hover {
  
  transform: translate(-50%, -2%); /* Slight upward movement on hover */
  box-shadow: 0 0 20px gold, 0 0 40px gold, 0 0 60px gold; /* Glowing effect */
}

/* Optional: Add a keyframe animation for pulsating glow */
@keyframes glow {
  0% {
    box-shadow: 0 0 10px gold, 0 0 20px gold, 0 0 30px goldenrod;
  }
  50% {
    box-shadow: 0 0 20px gold, 0 0 40px gold, 0 0 60px goldenrod;
  }
  100% {
    box-shadow: 0 0 10px gold, 0 0 20px gold, 0 0 30px goldenrod;
  }
}

#login-box:hover {
  animation: glow 1.5s infinite; /* Pulsating glowing animation */
}

#login-box .logo .logo-caption {
  font-family: 'Poiret One', cursive;
  color: white;
  text-align: center;
  margin-bottom: 0px;
}
#login-box .logo .tweak {
  color: #b1c900;
}
#login-box .controls {
  padding-top: 30px;
}
#login-box .controls input {
  border-radius: 0px;
  background: rgb(98, 96, 96);
  border: 0px;
  color: white;
}
#login-box .controls input:focus {
  box-shadow: none;
}
#login-box .controls input:first-child {
  border-top-left-radius: 2px;
  border-top-right-radius: 2px;
}
#login-box .controls input:last-child {
  border-bottom-left-radius: 2px;
  border-bottom-right-radius: 2px;
}
#login-box button.btn-custom {
  border-radius: 2px;
  margin-top: 8px;
  background:#b1c900;
  border-color: rgba(48, 46, 45, 1);
  color: white;
}
#login-box button.btn-custom:hover{
  -webkit-transition: all 500ms ease;
  -moz-transition: all 500ms ease;
  -ms-transition: all 500ms ease;
  -o-transition: all 500ms ease;
  transition: all 500ms ease;
  background: rgba(48, 46, 45, 1);
  border-color: #b1c900;
}
#particles-js{
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: 50% 50%;
    position: fixed;
    top: 0px;
    z-index:1;
}
    </style>
</head>

<body>
    <div class="container">
        <div id="login-box">
            <div class="logo">
                <img src="https://static.vecteezy.com/system/resources/previews/019/879/186/non_2x/user-icon-on-transparent-background-free-png.png" class="img img-responsive img-circle center-block" height="100" width="100"/>
                <h1 class="logo-caption"><span class="tweak">L</span>ogin</h1>
            </div><!-- /.logo -->
            <div class="controls">
                <form action="" method="post">
                <input type="text" id="username" name="username" placeholder="Username" class="form-control" />
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" style="margin-top:10%" />
                <button type="submit" class="btn btn-default btn-block btn-custom"  style="margin-top:10%">Login</button>
                <br>
                <center>
                    <a class="text-center" href="../index.php">Go to Home</a>
                
                </center>
                </form>
            </div>
        </div>
    </div>
    <div id="particles-js"></div>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css"></script>
    <script src="https://www.marcoguglie.it/Codepen/AnimatedHeaderBg/demo-1/js/rAF.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script>
       $.getScript("https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js", function(){
    particlesJS('particles-js',
      {
        "particles": {
          "number": {
            "value": 100,
            "density": {
              "enable": true,
              "value_area": 500
            }
          },
          "color": {
            "value": "#b1c900"
          },
          "shape": {
            "type": "circle",
            "stroke": {
              "width": 0,
              "color": "#000000"
            },
            "polygon": {
              "nb_sides": 5
            },
            "image": {
              "width": 100,
              "height": 100
            }
          },
          "opacity": {
            "value": 0.5,
            "random": false,
            "anim": {
              "enable": false,
              "speed": 1,
              "opacity_min": 0.1,
              "sync": false
            }
          },
          "size": {
            "value": 5,
            "random": true,
            "anim": {
              "enable": false,
              "speed": 40,
              "size_min": 0.1,
              "sync": false
            }
          },
          "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#ffffff",
            "opacity": 0.4,
            "width": 1
          },
          "move": {
            "enable": true,
            "speed": 6,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "attract": {
              "enable": false,
              "rotateX": 600,
              "rotateY": 1200
            }
          }
        },
        "interactivity": {
          "detect_on": "canvas",
          "events": {
            "onhover": {
              "enable": true,
              "mode": "repulse"
            },
            "onclick": {
              "enable": true,
              "mode": "push"
            },
            "resize": true
          },
          "modes": {
            "grab": {
              "distance": 400,
              "line_linked": {
                "opacity": 1
              }
            },
            "bubble": {
              "distance": 400,
              "size": 40,
              "duration": 2,
              "opacity": 8,
              "speed": 3
            },
            "repulse": {
              "distance": 100
            },
            "push": {
              "particles_nb": 4
            },
            "remove": {
              "particles_nb": 2
            }
          }
        },
        "retina_detect": true,
        "config_demo": {
          "hide_card": false,
          "background_color": "#b61924",
          "background_image": "",
          "background_position": "50% 50%",
          "background_repeat": "no-repeat",
          "background_size": "cover"
        }
      }
    );

});




    </script>

</body>

</html>