<?php
include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $branch_id = $_POST['branch_id'];
    $class_name = $_POST['class_name'];
    $teacher_id = $_POST['teacher_id'];

    // Validate the data
    if (empty($branch_id) || empty($class_name) || empty($teacher_id)) {
        // Redirect to add class page with an error
        header("Location: add_class.php?status=error");
        exit();
    }

    // Insert class details into the database
    $insertQuery = "INSERT INTO classes (branch_id, class_name, teacher_id) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($conn, $insertQuery)) {
        mysqli_stmt_bind_param($stmt, "iss", $branch_id, $class_name, $teacher_id);
        
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to add class page with success status
            header("Location: view_class.php?status=success");
            exit();
        } else {
            // Error while inserting, redirect with error status
            header("Location: add_class.php?status=error");
            exit();
        }
    } else {
        // Error while preparing statement
        header("Location: add_class.php?status=error");
        exit();
    }
} else {
    // If the form is not submitted properly, redirect to add class page
    header("Location: add_class.php");
    exit();
}
?>
