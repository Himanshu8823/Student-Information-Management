<?php
session_start();
error_reporting(0);
include('../connection/connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all branches
$branches_query = "SELECT * FROM branches";
$branches_result = mysqli_query($conn, $branches_query);

// Handle form submission for attendance
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $attendance_data = $_POST['attendance']; // This will contain the student attendance data

    // Insert attendance for each student
    foreach ($attendance_data as $student_id => $status) {
        // Check if the student ID exists in the students table
        $check_student_query = "SELECT 1 FROM tblstudent WHERE ID = ?";
        $stmt_check = mysqli_prepare($conn, $check_student_query);
        mysqli_stmt_bind_param($stmt_check, 'i', $student_id);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        // If student exists, insert attendance
        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $status = ($status == 'present') ? 'present' : 'absent';

            // Prepare and insert attendance data
            $insert_attendance = "INSERT INTO attendance (ID, class_id, status, teacher_id, created_at, attendance_date) VALUES (?, ?, ?, ?, NOW(), CURDATE())";
            $stmt = mysqli_prepare($conn, $insert_attendance);
            mysqli_stmt_bind_param($stmt, 'iisi', $student_id, $class_id, $status, $_SESSION['user_id']);
            
            if (mysqli_stmt_execute($stmt)) {
                $message = "Attendance marked successfully!";
            } else {
                $error = mysqli_error($conn);
                $message = "Error: $error";
            }
        } else {
            $message = "Student ID $student_id does not exist.";
        }
    }
}


// Fetch classes for a specific branch (AJAX)
if (isset($_GET['branch_id'])) {
    $branch_id = $_GET['branch_id'];
    $classes_query = "SELECT * FROM classes WHERE branch_id = ?";
    $stmt = mysqli_prepare($conn, $classes_query);
    mysqli_stmt_bind_param($stmt, 'i', $branch_id);
    mysqli_stmt_execute($stmt);
    $classes_result = mysqli_stmt_get_result($stmt);
    $classes = [];
    while ($row = mysqli_fetch_assoc($classes_result)) {
        $classes[] = $row;
    }
    echo json_encode($classes);
    exit();
}

// Fetch students for the selected class
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];
    $students_query = "SELECT * FROM tblstudent WHERE class_id = ?";
    $stmt = mysqli_prepare($conn, $students_query);
    mysqli_stmt_bind_param($stmt, 'i', $class_id);
    mysqli_stmt_execute($stmt);
    $students_result = mysqli_stmt_get_result($stmt);
    $students = [];
    while ($row = mysqli_fetch_assoc($students_result)) {
        $students[] = $row;
    }
    echo json_encode($students);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
    <style>
        .dt-buttons {
            float: right;
            margin-right: 10px;
        }

        .dataTables_filter {
            float: left !important;
            padding-left: 10px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>

            <div class="main-content">
                <div class="container bg-white">
                    <h2>Add Attendance</h2>

                    <!-- Success or Error Message -->
                    <?php if (isset($message)) {
                        echo '<div class="alert alert-success">' . $message . '</div>';
                    } ?>

                    <!-- Attendance Form -->
                    <form action="add_attendance.php" method="POST">
                        <div class="form-group">
                            <label for="branch">Select Branch:</label>
                            <select class="form-control" id="branch" name="branch_id">
                                <option value="">Select Branch</option>
                                <?php while ($branch = mysqli_fetch_assoc($branches_result)) { ?>
                                    <option value="<?php echo $branch['branch_id']; ?>">
                                        <?php echo $branch['branch_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="class">Select Class:</label>
                            <select class="form-control" id="class" name="class_id" disabled>
                                <option value="">Select Class</option>
                            </select>
                        </div>

                        <div class="mt-4" id="students-table">
                            <!-- Students Table will appear here -->
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit Attendance</button>
                    </form>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>
    <script>
        // Fetch classes when a branch is selected
        $('#branch').change(function () {
            const branch_id = $(this).val();
            if (branch_id) {
                $.ajax({
                    url: 'add_attendance.php',
                    method: 'GET',
                    data: { branch_id: branch_id },
                    success: function (response) {
                        const classes = JSON.parse(response);
                        let options = '<option value="">Select Class</option>';
                        classes.forEach(function (classItem) {
                            options += `<option value="${classItem.class_id}">${classItem.class_name}</option>`;
                        });
                        $('#class').html(options).prop('disabled', false);
                    }
                });
            } else {
                $('#class').prop('disabled', true);
            }
        });

        // Fetch students when a class is selected
        $('#class').change(function () {
            const class_id = $(this).val();
            if (class_id) {
                $.ajax({
                    url: 'add_attendance.php',
                    method: 'GET',
                    data: { class_id: class_id },
                    success: function (response) {
                        const students = JSON.parse(response);
                        let studentsTable = `
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Student ID</th>
                                        <th>Present</th>
                                        <th>Absent</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;
                        students.forEach(function (student) {
                            studentsTable += `
                                <tr>
                                    <td>${student.StudentName}</td>
                                    <td>${student.StuID}</td>
                                    <td><input type="radio" name="attendance[${student.ID}]" value="present"></td>
                                    <td><input type="radio" name="attendance[${student.ID}]" value="absent"></td>
                                </tr>
                            `;
                        });
                        studentsTable += `</tbody></table>`;
                        $('#students-table').html(studentsTable);
                    }
                });
            }
        });
    </script>
</body>

</html>
