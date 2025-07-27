<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);
include('../connection/connect.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = isset($_POST['student_id']) ? mysqli_real_escape_string($conn, $_POST['student_id']) : null;
    $document_type = isset($_POST['document_type']) ? mysqli_real_escape_string($conn, $_POST['document_type']) : null;

    // Validate inputs
    if (empty($student_id) || empty($document_type)) {
        echo 'All fields are required.<br>';
        exit();
    }

    // Check if file is uploaded
    if (isset($_FILES['document_file']) && $_FILES['document_file']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_name = $_FILES['document_file']['tmp_name'];
        $file_name = $_FILES['document_file']['name'];
        $file_size = $_FILES['document_file']['size'];
        $file_error = $_FILES['document_file']['error'];


        // Check file size (example: max 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            echo '<script> alert("File size exceeds the 5MB limit.<br>"); </script><br>';
            exit();
        }

        // Validate file type (example: only allow PDF and image files)
        $allowed_types = ['pdf', 'jpg', 'jpeg', 'png'];
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_types)) {
            echo '<script> alert("Invalid file type. Only PDF, JPG, JPEG, and PNG are allowed."); </script><br>';
            exit();
        }

        // Generate unique file name to avoid conflicts
        $new_file_name = uniqid('doc_', true) . '.' . $file_extension;
        echo "Generated file name: $new_file_name<br>";

        // Destination directory (ensure this exists and is writable)
        $upload_dir = 'documents/';
        if (!is_dir($upload_dir)) {
            if (mkdir($upload_dir, 0777, true)) {
                echo 'Directory created: ' . $upload_dir . '<br>';
            } else {
                echo 'Failed to create directory: ' . $upload_dir . '<br>';
                exit();
            }
        }

        // Move the uploaded file to the destination directory
        $destination = $upload_dir . $new_file_name;
        if (move_uploaded_file($file_tmp_name, $destination)) {
            

            // File uploaded successfully
            $file_path = 'documents/' . $new_file_name;
            $uploaded_at = date('Y-m-d H:i:s'); // Get current date and time for uploaded_at

            // Insert into database using regular SQL query
            $query = "INSERT INTO documents (ID, document_type, document_file, uploaded_at) 
                      VALUES ('$student_id', '$document_type', '$file_path', '$uploaded_at')";
            

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Document Uploaded Successfully');</script>";
                header('Location: view_document.php?status=success');
                exit();
            } else {
                header('Location: add_document.php?status=error');
                exit();
            }
        } else {
            header('Location: add_document.php');
            exit();
        }
    } else {
        // Handle file upload error
        if ($_FILES['document_file']['error'] !== UPLOAD_ERR_OK) {
            echo 'Error uploading file. Error code: ' . $_FILES['document_file']['error'] . '<br>';
            exit();
        }
    }
} else {
    echo 'Invalid request method.<br>';
    exit();
}
?>
