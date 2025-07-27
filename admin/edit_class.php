<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('../connection/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = mysqli_real_escape_string($conn, $_POST['class_id']);
    $class_name = mysqli_real_escape_string($conn, $_POST['class_name']);
    $branch_id = mysqli_real_escape_string($conn, $_POST['branch_id']);
    $teacher_id = mysqli_real_escape_string($conn, $_POST['teacher_id']);

    $sql_update = "UPDATE classes 
                   SET class_name = '$class_name', 
                       branch_id = $branch_id, 
                       teacher_id = $teacher_id 
                   WHERE class_id = $class_id";

    if (mysqli_query($conn, $sql_update)) {

        header("Location: view_class.php?status=success");
        exit();
    } else {
        header("Location: view_class.php?status=error");
        exit();
    }
} else {
    header("Location: view_class.php");
    exit();
}
?>
