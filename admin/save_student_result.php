<?php
include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve student ID from the form
    $student_id = intval($_POST['student_id']);

    // Fetch the class ID associated with the student
    $class_query = "SELECT class_id FROM tblstudent WHERE ID = $student_id";
    $class_result = mysqli_query($conn, $class_query);

    if ($class_result && mysqli_num_rows($class_result) > 0) {
        $class_row = mysqli_fetch_assoc($class_result);
        $class_id = $class_row['class_id'];
    } else {
        header("Location: add_results.php?status=error&message=Invalid%20student%20ID%20or%20no%20class%20found");
        exit();
    }

    // Prepare to insert results
    $insert_values = [];

    foreach ($_POST as $key => $value) {
        // Extract subject ID and marks/total marks from input names
        if (strpos($key, 'marks_') === 0) {
            $subject_id = str_replace('marks_', '', $key);
            $marks = intval($value);
            $total_marks = intval($_POST['total_marks_' . $subject_id]);

            // Build values for the INSERT query
            $insert_values[] = "($class_id, $student_id, $subject_id, $marks, $total_marks)";
        }
    }

    // Insert data into the result table
    if (!empty($insert_values)) {
        $insert_query = "
            INSERT INTO results (class_id, ID, subject_id, marks, total_marks) 
            VALUES " . implode(', ', $insert_values);

        if (mysqli_query($conn, $insert_query)) {
            header("Location: add_results.php?status=success");
            exit();
        } else {
            $error_message = urlencode("Failed to save results: " . mysqli_error($conn));
            echo $error_message;
            //header("Location: add_results.php?status=error&message=$error_message");
            //exit();
        }
    } else {
        echo mysqli_error($conn);
        //header("Location: add_results.php?status=error&message=No%20results%20to%20save");
        //exit();
    }
} else {
    header("Location: add_results.php?status=error&message=Invalid%20request%20method");
    exit();
}

exit();
?>
