<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);

include('../connection/connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $branch_name = $_POST['branch_name'];

    if (empty($branch_name)) {
        header("Location: view_branch.php?status=error");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO branches (branch_name) VALUES (?)");
    $stmt->bind_param("s", $branch_name);

    if ($stmt->execute()) {
        header("Location: view_branch.php?status=success");
    } else {
    
        header("Location: view_branch.php?status=error");
    }


    $stmt->close();
}
?>
