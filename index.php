<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Management System - Login</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <style>
        /* Fullscreen Layout */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            color: white;
            position: relative;
        }

        /* Background Video */
        .background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Custom Card Styling */
        .card {
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 255, 0, 0.3);
            padding: 2rem;
            color: #fff;
            position: relative;
            overflow: hidden;
            transition: transform 0.5s ease, box-shadow 0.3s ease;
        }
        
        /* Smooth Hover Animations */
        .card:hover {
            transform: translateY(-15px) scale(1.08) rotateY(10deg); /* Added scale and rotation */
            box-shadow: 0px 6px 30px rgba(0, 255, 0, 0.6);
        }

        .card-title {
            color: #00ff00;
        }

        .btn-primary {
            background-color: #006400; /* Dark green */
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #004d00; /* Darker green on hover */
            transform: scale(1.05);
        }

        /* Responsive Card Grid */
        .card-deck {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        /* Ensure cards stay on top */
        .container {
            position: relative;
            z-index: 1;
        }
        
        .card-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .container {
            padding: 3rem 0;
        }
    </style>
</head>
<body>

    <video class="background-video" autoplay muted loop>
        <source src="assets/start_animation.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container d-flex align-items-center justify-content-center" style="height: 100vh;">
        <div class="card-deck">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Student Login</h5>
                    <p class="card-text">Access your student dashboard.</p>
                    <a href="student_login.php" class="btn btn-primary">Login</a>
                </div>
            </div>
            <!-- Teacher Login Card -->
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Teacher Login</h5>
                    <p class="card-text">Access your teacher dashboard.</p>
                    <a href="admin/teacher_login.php" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="admin/js/jquery-3.3.1.min.js"></script>
    <script src="admin/js/bootstrap.min.js"></script>
</body>
</html>
