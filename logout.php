<?php
session_start();

// Destroy all session variables to log the user out
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page after logout
header("Location: student_login.php");
exit();
?>
