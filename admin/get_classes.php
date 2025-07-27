<?php
include('../connection/connect.php');

// Check if the branch_id is set
if (isset($_POST['branch_id'])) {
    $branch_id = $_POST['branch_id'];

    // Fetch classes associated with the branch
    $sql = "SELECT * FROM classes WHERE branch_id = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $branch_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if classes are found
        if (mysqli_num_rows($result) > 0) {
            // Loop through and output each class as an option
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['class_id'] . '">' . $row['class_name'] . '</option>';
            }
        } else {
            echo '<option value="">No classes found</option>';
        }
    }
}
?>
