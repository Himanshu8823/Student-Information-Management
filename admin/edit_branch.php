<?php
include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['branch_id']) && isset($_POST['branch_name'])) {
    $branch_id = $_POST['branch_id'];
    $branch_name = mysqli_real_escape_string($conn, $_POST['branch_name']);

    // Update branch details in the database
    $update_query = "UPDATE branches SET branch_name='$branch_name' WHERE branch_id='$branch_id'";
    if (mysqli_query($conn, $update_query)) {
        // Redirect back to view_branch.php with success status
        header("Location: view_branch.php?status=success");
    } else {
        // Redirect back to view_branch.php with error status
        header("Location: view_branch.php?status=error");
    }
    exit();
} else {
    header("Location: view_branch.php?status=error");
    exit();
}
