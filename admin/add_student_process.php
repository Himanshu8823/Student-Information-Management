<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('../connection/connect.php'); // Database connection file

if (isset($_POST['submit'])) {
    // Fetch form inputs
    $stuname = mysqli_real_escape_string($conn, $_POST['stuname']);
    $stuemail = mysqli_real_escape_string($conn, $_POST['stuemail']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $connum = mysqli_real_escape_string($conn, $_POST['connum']);
    $altconnum = mysqli_real_escape_string($conn, $_POST['altconnum']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);



    // Validate that the class belongs to the branch
    $validate_class_query = "SELECT * FROM classes WHERE class_id = '$class_id'";
    $validate_class_result = mysqli_query($conn, $validate_class_query);

    $q = "SELECT * FROM tblstudent ORDER BY StuID DESC LIMIT 1";
    $res = mysqli_query($conn,$q);
    $row1 = mysqli_fetch_assoc($res);
    $stu_id = $row1['StuID'] + 1;


    if (mysqli_num_rows($validate_class_result) > 0) {
        // Insert student into the database
        $insert_student_query = "
            INSERT INTO tblstudent 
            (StudentName, StudentEmail, Gender, DOB, FatherName, MotherName, ContactNumber, AltenateNumber, Address, UserName, Password, class_id,StuID) 
            VALUES 
            ('$stuname', '$stuemail', '$gender', '$dob', '$fname', '$mname', '$connum', '$altconnum', '$address', '$uname', '$password', '$class_id','$stu_id')";
        $insert_student_result = mysqli_query($conn, $insert_student_query);

        if ($insert_student_result) {
            echo "successs";
            header("Location: view_student.php?status=success"); // Redirect to view students
           exit;
        } else {
            echo "Failed to add student. Please try again.";
            echo mysqli_error($conn);
        }
    } else {
        echo "Invalid class selected for the chosen branch.";
    }
} else {
    echo "Invalid request.";
}

echo "This is debugging";
?>
