<?php
// Include the database connection
include '../connection/connect.php';

error_reporting(E_ALL ^ E_NOTICE);
// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Get the student ID from the URL
    $eid = $_GET['id'];

    // Retrieve form data and sanitize it
    $stuname = mysqli_real_escape_string($conn, $_POST['stuname']);
    $stuemail = mysqli_real_escape_string($conn, $_POST['stuemail']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $stuid = mysqli_real_escape_string($conn, $_POST['stuid']);
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $connum = mysqli_real_escape_string($conn, $_POST['connum']);
    $altconnum = mysqli_real_escape_string($conn, $_POST['altconnum']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $uname = mysqli_real_escape_string($conn, $_POST['uname']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare the SQL update query
    $sql = "UPDATE tblstudent SET 
                StudentName = '$stuname',
                StudentEmail = '$stuemail',
                Gender = '$gender',
                DOB = '$dob',
                FatherName = '$fname',
                MotherName = '$mname',
                ContactNumber = '$connum',
                AltenateNumber = '$altconnum',
                Address = '$address'
            WHERE ID='$eid'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        
        header("Location: view_student.php"); // Change this to your success page
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>