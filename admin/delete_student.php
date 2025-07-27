<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

// Check if the student ID is provided in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Ensure the ID is a valid integer to prevent SQL injection
    if (filter_var($student_id, FILTER_VALIDATE_INT)) {
        // Delete the student record from the database
        $sql = "DELETE FROM tblstudent WHERE ID = $student_id";
        
        if (mysqli_query($conn, $sql)) {
            // Redirect to the view_students.php page with a success status
            header("Location: view_student.php?status=success");
            exit();
        } else {
            // If there's an error in the query, redirect with an error status
            header("Location: view_student.php?status=error");
            exit();
        }
    } else {
        // If the ID is not valid, redirect with an error status
        header("Location: view_student.php?status=error");
        exit();
    }
} else {
    // If the ID is not provided, redirect with an error status
    header("Location: view_student.php?status=error");
    exit();
}
?>
