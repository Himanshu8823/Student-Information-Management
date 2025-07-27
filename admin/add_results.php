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
    <title>Add Results</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
        href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css"
        rel="stylesheet">
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
                    <h1 class="mt-5 text-gray text-left">Add Results</h1>
                    <div class="table-responsive mt-5">
                        <table class="table table-bordered table-striped mt-4 mb-4 pb-4" name="result_table" id="result_table">
                            <thead class="thead-dark">
                                <th>ID</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Branch</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                // SQL Query to fetch student data with additional check for marks submission
                                $query = "
                                        SELECT 
                                            tblstudent.ID AS StudentID, 
                                            tblstudent.StudentName, 
                                            classes.class_name, 
                                            branches.branch_name,
                                            (SELECT COUNT(*) 
                                            FROM results 
                                            WHERE results.ID = tblstudent.ID) AS has_results
                                        FROM tblstudent
                                        INNER JOIN classes ON tblstudent.class_id = classes.class_id
                                        INNER JOIN branches ON classes.branch_id = branches.branch_id
                                    ";

                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                                <td>{$row['StudentID']}</td>
                                                <td>{$row['StudentName']}</td>
                                                <td>{$row['class_name']}</td>
                                                <td>{$row['branch_name']}</td>
                                                <td>";

                                        // Check if marks are already submitted
                                        if ($row['has_results'] > 0) {
                                            echo "<button class='btn btn-success btn-sm' disabled>Submitted</button>";
                                        } else {
                                            echo "<a href='add_student_result.php?student_id={$row['StudentID']}' class='btn btn-primary btn-sm'>Add Result</a>";
                                        }

                                        echo "</td>
        </tr>";
                                    }
                                } else {
                                    echo "<tr>
        <td colspan='5' class='text-center'>No students found</td>
    </tr>";
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
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
                    Results updated successfully.
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

    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


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
</body>

</html>