<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['notice_id']) && isset($_POST['notice_name']) && isset($_POST['notice_content'])) {
    $notice_id = $_POST['notice_id'];
    $notice_title = mysqli_real_escape_string($conn, $_POST['notice_name']);
    $notice_content = mysqli_real_escape_string($conn, $_POST['notice_content']);

    echo "Notice ID: " . $notice_id . "<br>";
    echo "Notice Title: " . $notice_title . "<br>";
    echo "Notice Content: " . $notice_content . "<br>";

    $update_query = "UPDATE notices SET notice_title='$notice_title', content='$notice_content' WHERE notice_id='$notice_id'";

    echo "SQL Query: " . $update_query . "<br>";

    if (mysqli_query($conn, $update_query)) {
        header("Location: view_notice.php?status=success");
    } else {
        
        header("Location: view_notice.php?status=error");
    }
    exit();
} else {
    
    echo "Missing parameters!<br>";
    //header("Location: view_notice.php?status=error");
    //exit();
}
