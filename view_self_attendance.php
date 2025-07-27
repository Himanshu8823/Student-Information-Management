<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('connection/connect.php');

// Check if the user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Get student information from session
$student_id = intval($_SESSION['student_id']);

// Fetch attendance data for the student
$attendance_query = "
    SELECT classes.class_name, attendance.status, attendance.attendance_date 
    FROM attendance
    JOIN classes ON attendance.class_id = classes.class_id
    WHERE attendance.ID = ?
    ORDER BY attendance.attendance_date DESC
";

$stmt = mysqli_prepare($conn, $attendance_query);
mysqli_stmt_bind_param($stmt, 'i', $student_id);
mysqli_stmt_execute($stmt);
$attendance_result = mysqli_stmt_get_result($stmt);
$attendance_data = [];
while ($row = mysqli_fetch_assoc($attendance_result)) {
    $attendance_data[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Self Attendance</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom 3D Animation Styles -->
    <style>
        body {
            background-color: #fff;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .attendance-wrapper {
            margin-top: 30px;
            padding: 20px;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th, .attendance-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .attendance-table th {
            background-color: #007bff;
            color: #fff;
        }

        .attendance-table td {
            background-color: #f9f9f9;
        }

        .attendance-table .present {
            color: #28a745;
            font-weight: bold;
        }

        .attendance-table .absent {
            color: #dc3545;
            font-weight: bold;
        }

        .attendance-table td time {
            font-size: 0.85rem;
            color: #888;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .attendance-table th, .attendance-table td {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<?php include("header.php"); ?>

    <!-- Main Container -->
    <div class="container mt-5">
        <h1 class="text-center text-dark mb-4">Your Attendance Overview</h1>

        <div class="attendance-wrapper">
            <?php if (count($attendance_data) > 0): ?>
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Status</th>
                            <th>Attendance Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance_data as $attendance): ?>
                            <tr>
                                <td><?php echo htmlentities($attendance['class_name']); ?></td>
                                <td class="<?php echo $attendance['status'] == 'present' ? 'present' : 'absent'; ?>">
                                    <?php echo $attendance['status'] == 'present' ? 'Present' : 'Absent'; ?>
                                </td>
                                <td>
                                    <time><?php echo date('d M Y', strtotime($attendance['attendance_date'])); ?></time>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <span class="text-center mt-4 ms-4 display-6">
                    <?php
                            $total= count($attendance_data);
                            $student_id = $_SESSION['student_id'];
                            $q = "SELECT * FROM attendance WHERE status='present' and ID='$student_id'";
                            $result = mysqli_query($conn, $q);
                            $present = mysqli_num_rows($result);
                            $absent = intval($total) - intval($present);
                            $percentage = ($present / $total) * 100;
                            echo "<br>Total Attendance: $total";
                            echo "<br>Present: $present";
                            echo "<br>Absent: $absent";
                            echo "<br>Attendance Percentage: $percentage%";
                    ?>
                </span>
            <?php                 
        else: ?>
                <div class="alert alert-warning" role="alert">
                    No Attendance Records Found.
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php include("footer.php"); ?>

    <!-- Bootstrap JS and Popper -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
