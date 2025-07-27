<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

// Check if student_id is passed in the GET request
if (isset($_GET['student_id'])) {
    $student_id = intval($_GET['student_id']);

    // Fetch class and branch details based on student_id
    $query = "
        SELECT 
            tblstudent.ID AS StudentID, 
            tblstudent.StudentName, 
            classes.class_id AS ClassID, 
            classes.class_name, 
            branches.branch_name 
        FROM tblstudent
        INNER JOIN classes ON tblstudent.class_id = classes.class_id
        INNER JOIN branches ON classes.branch_id = branches.branch_id
        WHERE tblstudent.ID = $student_id
    ";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
        $class_id = $student['ClassID'];
        $class_name = $student['class_name'];
        $branch_name = $student['branch_name'];
        $student_name = $student['StudentName'];
    } else {
        die("Invalid student ID or no data found.");
    }

    // Fetch subjects for the class and branch
    $subject_query = "
        SELECT 
            subjects.subject_id AS SubjectID, 
            subjects.subject_name 
        FROM subjects
        WHERE subjects.class_id = $class_id
    ";
    $subject_result = mysqli_query($conn, $subject_query);
} else {
    die("Student ID not provided.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student Result</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>
            <div class="main-content">
                <div class="container bg-white">
                    <h2 class="text-center mb-4">Add Result for Student</h2>
                    <div class="card">
                        <div class="card-body">
                            <h4>Student Details</h4>
                            <p><strong>ID:</strong> <?php echo $student['StudentID']; ?></p>
                            <p><strong>Name:</strong> <?php echo $student_name; ?></p>
                            <p><strong>Class:</strong> <?php echo $class_name; ?></p>
                            <p><strong>Branch:</strong> <?php echo $branch_name; ?></p>
                        </div>
                    </div>

                    <form action="save_student_result.php" method="POST" class="mt-4">
                        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                        <div class="card">
                            <div class="card-body">
                                <h4>Subjects</h4>
                                <?php
                                if ($subject_result && mysqli_num_rows($subject_result) > 0) {
                                    while ($subject = mysqli_fetch_assoc($subject_result)) {
                                        echo "
                        <div class='form-group'>
                            <label for='subject_{$subject['SubjectID']}'>{$subject['subject_name']} - Marks</label>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <input type='number' class='form-control' name='marks_{$subject['SubjectID']}' id='marks_{$subject['SubjectID']}' placeholder='Enter Marks' required>
                                </div>
                                <div class='col-md-6'>
                                    <input type='number' class='form-control' name='total_marks_{$subject['SubjectID']}' id='total_marks_{$subject['SubjectID']}' placeholder='Enter Total Marks' required>
                                </div>
                            </div>
                        </div>
                    ";
                                    }
                                } else {
                                    echo "<p>No subjects found for this class.</p>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-success mb-5">Save Result</button>
                            <a href="add_results.php" class="btn btn-secondary mb-5">Back</a>
                        </div>
                    </form>

                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <p class="copyright d-flex justify-content-end"> &copy 2024 Design by &nbsp;
                                    <a href="#"> MP </a>&nbsp; BootStrap Admin Dashboard
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>


    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

            $('#result_table').DataTable();
        });
    </script>
</body>

</html>