<?php
include('../connection/connect.php');
session_start();

error_reporting(E_ALL ^ E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Classes</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
        href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css"
        rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>
            <div class="main-content">
                <div class="container bg-white">
                    <h1 class="mt-5 text-gray text-left">Add Classes</h1>

                    <center>
                        <button class="btn btn-success mt-5 mb-5" data-toggle="modal" data-target="#addClassModal">Add
                            Class</button>
                    </center>
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
    <!-- Add Class Modal -->
    <div class="modal fade" id="addClassModal" tabindex="-1" role="dialog" aria-labelledby="addClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addClassModalLabel">Add Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_new_class.php" method="POST">
                    <div class="modal-body">
                        <!-- Branch Name Field -->
                        <div class="form-group">
                            <label for="branch_id">Branch Name</label>
                            <select class="form-control" name="branch_id" id="branch_id" required>
                                <option value="" disabled selected>Select Branch</option>
                                <?php
                                // Fetch branch names and IDs from the database
                                $branchQuery = "SELECT branch_id, branch_name FROM branches";
                                $branchResult = mysqli_query($conn, $branchQuery);
                                while ($branch = mysqli_fetch_assoc($branchResult)) {
                                    echo "<option value='{$branch['branch_id']}'>{$branch['branch_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Class Name Field -->
                        <div class="form-group">
                            <label for="class_name">Class Name</label>
                            <input type="text" class="form-control" name="class_name" id="class_name" required>
                        </div>

                        <!-- Teacher Name Field -->
                        <div class="form-group">
                            <label for="teacher_id">Teacher Name</label>
                            <select class="form-control" name="teacher_id" id="teacher_id" required>
                                <option value="" disabled selected>Select Teacher</option>
                                <?php
                                $teacherQuery = "SELECT t.teacher_id, u.name AS teacher_name 
                                    FROM teachers t
                                    JOIN users u ON t.user_id = u.user_id";
                                                    $teacherResult = mysqli_query($conn, $teacherQuery);

                                while ($teacher = mysqli_fetch_assoc($teacherResult)) {
                                    echo "<option value='{$teacher['teacher_id']}'>{$teacher['teacher_name']}</option>";
                                }
                                ?>

                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Class details added successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Something went wrong. Please try again.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            if (status === 'success') {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
                setTimeout(function () {
                    history.replaceState(null, null, window.location.pathname);
                    successModal.hide();
                }, 2000);
            } else if (status === 'error') {
                const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
                setTimeout(function () {
                    history.replaceState(null, null, window.location.pathname);
                    errorModal.hide();
                }, 2000);
            }
        });
    </script>

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
        });
    </script>
</body>

</html>