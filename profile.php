<?php
session_start();
error_reporting(0);
include('connection/connect.php');
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$student_id = $_SESSION['student_id'];

$sql = "SELECT tblstudent.*, classes.class_name, classes.branch_id, branches.branch_name
FROM tblstudent 
JOIN classes ON tblstudent.class_id = classes.class_id
JOIN branches ON classes.branch_id = branches.branch_id
WHERE tblstudent.ID = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $student_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if ($result && mysqli_num_rows($result) > 0) {
    $student = mysqli_fetch_assoc($result);
} else {
    echo "Student not found!";
    exit();
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .profile-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
        }

        .profile-container {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            transform: perspective(750px) translate3d(0px, 0px, -250px) rotateX(27deg) scale(0.9, 0.9);
            border-radius: 20px;
            border: 5px solid #e6e6e6;
            box-shadow: 0 70px 40px -20px rgba(0, 0, 0, 0.2);
            transition: 0.4s ease-in-out transform;
        }

        .profile-container:hover {
            transform: translate3d(0px, 0px, -250px);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ddd;
        }

        .profile-header h2 {
            font-size: 2rem;
            color: #333;
            margin-top: 10px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .profile-info label {
            font-weight: 500;
            color: #555;
        }

        .profile-info .form-group {
            margin-bottom: 15px;
        }

        .profile-info input[readonly] {
            border: none;
            background: #f8f9fa;
            color: #333;
            padding: 10px;
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="profile-wrapper">
        <div class="col-md-6">
            <div class="profile-container">
                <div class="profile-header">
                    <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Student Avatar">
                    <h2><?php echo $student['StudentName']; ?></h2>
                </div>
                <div class="profile-info">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control"
                            value="<?php echo htmlentities($student['StudentName']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" class="form-control"
                            value="<?php echo htmlentities($student['StudentEmail']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="student_id">Student ID:</label>
                        <input type="text" id="student_id" class="form-control"
                            value="<?php echo htmlentities($student['StuID']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <input type="text" id="gender" class="form-control"
                            value="<?php echo htmlentities($student['Gender']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="text" id="dob" class="form-control"
                            value="<?php echo htmlentities($student['DOB']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="class_name">Class:</label>
                        <input type="text" id="class_name" class="form-control"
                            value="<?php echo htmlentities($student['class_name']); ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="branch_name">Branch:</label>
                        <input type="text" id="branch_name" class="form-control"
                            value="<?php echo htmlentities($student['branch_name']); ?>" readonly>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="profile-container">
                <h3>Parents/Guardian's details</h3>
                <div class="form-group">
                    <label for="exampleInputName1">Father's Name</label>
                    <input type="text" name="fname" value="<?php echo htmlentities($row['FatherName']); ?>"
                        class="form-control" required="true">
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Mother's Name</label>
                    <input type="text" name="mname" value="<?php echo htmlentities($row['MotherName']); ?>"
                        class="form-control" required="true">
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Contact Number</label>
                    <input type="text" name="connum" value="<?php echo htmlentities($row['ContactNumber']); ?>"
                        class="form-control" required="true" maxlength="10" pattern="[0-9]+">
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Alternate Contact Number</label>
                    <input type="text" name="altconnum" value="<?php echo htmlentities($row['AltenateNumber']); ?>"
                        class="form-control" required="true" maxlength="10" pattern="[0-9]+">
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Address</label>
                    <textarea name="address" class="form-control"
                        required="true"><?php echo htmlentities($row['Address']); ?></textarea>
                </div>

                <h3>Login details</h3>
                <div class="form-group">
                    <label for="exampleInputName1">User Name</label>
                    <input type="text" name="uname" value="<?php echo htmlentities($row['UserName']); ?>"
                        class="form-control" readonly="true">
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Password</label>
                    <input id="password" type="password" name="password" value="<?php echo htmlentities($row['Password']); ?> "
                        class="form-control" readonly="true">
                </div>
                <button class="btn btn-success" type="button" onclick="showPassword()" id="showBtn">
                    Show password
                </button>

            </div>
        </div>
    </div>
    </div>
    <?php include("footer.php"); ?>
    <script>
       
        function showPassword(){
            var showBtn =document.getElementById('showBtn');
            var password = document.getElementById('password');
            if(showBtn.textContent === 'Show password'){
                showBtn.textContent = 'Hide password';
                password.type = 'text';
            }
            else
            {
                showBtn.textContent = 'Show password';
                password.type = 'password';
            }
        }
    
    </script>
</body>

</html>