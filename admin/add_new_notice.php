<?php
// Include database connection file
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $notice_title = mysqli_real_escape_string($conn, $_POST['Notice_name']);
    $content = mysqli_real_escape_string($conn, $_POST['notice_content']);
    
    // Get the current timestamp for created_at field
    $created_at = date('Y-m-d H:i:s');
    
    // Insert the notice into the database
    $insert_query = "INSERT INTO notices (notice_title, content, created_at) VALUES ('$notice_title', '$content', '$created_at')";
    
    if (mysqli_query($conn, $insert_query)) {
        // If the query was successful, redirect with a success status
        header("Location: add_notice.php?status=success");
        exit();
    } else {
        // If there was an error in the query, redirect with an error status
        header("Location: add_notice.php?status=error");
        exit();
    }
} else {
    // If the form was not submitted correctly, redirect to the add_notice page
    header("Location: add_notice.php");
    exit();
}
?>
