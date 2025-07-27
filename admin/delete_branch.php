<?php
include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);
if (isset($_GET['id'])) {
    $branch_id = $_GET['id'];

    $sql_delete = "DELETE FROM branches WHERE branch_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql_delete)) {
        mysqli_stmt_bind_param($stmt, 'i', $branch_id);
        
        if (mysqli_stmt_execute($stmt)) {
            header("Location: view_branch.php?status=success");
            exit;
        } else {        
            header("Location: view_branch.php?status=error");
            exit;
        }
    } else {
        
        header("Location: view_branch.php?status=error");
        exit;
    }
} else {    
    header("Location: view_branch.php?status=error");
    exit;
}
?>
