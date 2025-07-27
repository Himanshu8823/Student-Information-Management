<?php

include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);

if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];


    $deleteQuery = "DELETE FROM classes WHERE class_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $class_id);

    if ($stmt->execute()) {

        header("Location: view_class.php?status=success");
    } else {

        header("Location: view_class.php?status=error");
    }

    $stmt->close();
} else {

    header("Location: view_class.php?status=error");
}

$conn->close();
exit();
?>
