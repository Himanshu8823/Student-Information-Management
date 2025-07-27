<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);
$sql_classes = "SELECT COUNT(*) AS total_classes FROM classes";
$sql_branches = "SELECT COUNT(*) AS total_branches FROM branches";
$sql_students = "SELECT COUNT(*) AS total_students FROM tblstudent";
$sql_notices = "SELECT COUNT(*) AS total_notices FROM notices";
$result_classes = mysqli_query($conn, $sql_classes);
$result_branches = mysqli_query($conn, $sql_branches);
$result_students = mysqli_query($conn, $sql_students);
$result_notices = mysqli_query($conn, $sql_notices);
$total_classes = mysqli_fetch_assoc($result_classes)['total_classes'];
$total_branches = mysqli_fetch_assoc($result_branches)['total_branches'];
$total_students = mysqli_fetch_assoc($result_students)['total_students'];
$total_notices = mysqli_fetch_assoc($result_notices)['total_notices'];
$sql_attendance = "
    SELECT 
        student_id,
        COUNT(CASE WHEN status = 'Present' THEN 1 END) AS present_count,
        7 AS total_days,
        (COUNT(CASE WHEN status = 'Present' THEN 1 END) / 7) * 100 AS attendance_percentage
    FROM 
        attendance
    WHERE 
        attendance_date >= CURDATE() - INTERVAL 7 DAY
    GROUP BY 
        student_id
";
$result_attendance = mysqli_query($conn, $sql_attendance);
$attendance_data = [];
if ($result_attendance && mysqli_num_rows($result_attendance) > 0) {
    while ($row = mysqli_fetch_assoc($result_attendance)) {
        $attendance_data[] = $row['attendance_percentage'];
    }
} else { 
    $attendance_data = array(65, 59, 80, 81, 66, 75, 90);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Dashboard</title>
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
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-warning">
                                    <span class="material-icons">school</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Total Classes</strong></p>
                                <h3 class="card-title"><?php echo $total_classes; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons text-info">info</i>
                                    <a href="#">See detailed report</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-rose">
                                    <span class="material-icons">location_city</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Total Branches</strong></p>
                                <h3 class="card-title"><?php echo $total_branches; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">local_offer</i> Branch overview
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-success">
                                    <span class="material-icons">group</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Total Students</strong></p>
                                <h3 class="card-title"><?php echo $total_students; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">date_range</i> Active students
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-stats">
                            <div class="card-header">
                                <div class="icon icon-info">
                                    <span class="material-icons">announcement</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <p class="category"><strong>Total Notices</strong></p>
                                <h3 class="card-title"><?php echo $total_notices; ?></h3>
                            </div>
                            <div class="card-footer">
                                <div class="stats">
                                    <i class="material-icons">update</i> Latest notices
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Average Attendance for the Week</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="attendanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <p class="copyright d-flex justify-content-end"> &copy 2024 Design by &nbsp;
                                    <a href="#"> MP </a>&nbsp;  Admin Dashboard
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });
        });
        var attendanceData = <?php echo json_encode($attendance_data); ?>;
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var attendanceChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                datasets: [{
                    label: 'Average Attendance (%)',
                    data: attendanceData,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
        aspectRatio: 1.5, 
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw.toFixed(2) + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
