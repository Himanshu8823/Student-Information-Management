<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if(!isset($_SESSION['student_id']))
{
    header("location:index.php");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #1f1f1f;
        }

        .navbar-brand {
            color: gold !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: gold !important;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        .dropdown-menu {
            background-color: #333;
        }

        .dropdown-item {
            color: white !important;
        }

        .dropdown-item:hover {
            background-color: gold;
            color: #333;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Student Portal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="show_notices.php">Notices</a>
                    </li>
                    
                    
                    <?php
                        $student_id= $_SESSION['student_id'];
                        $sql= "SELECT * from tblstudent where ID ='$student_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                    ?>
                    <li class="nav-item">
                        
                        <a class="nav-link" href="#card1"><?php echo $row['StudentName']; ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
