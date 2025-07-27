<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

$sql_classes = "SELECT * FROM classes";
$result_classes = mysqli_query($conn, $sql_classes);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Branches</title>
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
                <div class="container bg-white ">
                    <h1 class="mt-5 text-gray text-center">View Classes</h1>
                    <div class="d-flex justify-content-end mt-4">
                        <div id="tableButtons" class="mb-3"></div>
                    </div>
                    <span class=" table-responsive">
                    <table id="branchesTable" class="table table-striped table-bordered mt-4 mb-4 pb-4">
                        <thead>
                            <tr>
                                <th class="text-center">Class ID</th>
                                <th class="text-center">Class Name</th>
                                <th class="text-center">Branch Name</th>
                                <th class="text-center">Class Teacher</th>

                                <th class="text-center">Class Created </th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_classes && mysqli_num_rows($result_classes) > 0) {
                                while ($row = mysqli_fetch_assoc($result_classes)) {

                                    $class_id = $row['class_id'];
                                    $class_name = $row['class_name'];
                                    $branch_id = $row['branch_id'];
                                    $teacher_id = $row['teacher_id'];
                                    $created_at = $row['created_at'];

                                    $branch_sql = "SELECT branch_name FROM branches WHERE branch_id = $branch_id";
                                    $branch_result = mysqli_query($conn, $branch_sql);
                                    $branch_name = mysqli_fetch_assoc($branch_result)['branch_name'];

                                    $teacher_sql = "SELECT u.name FROM users u
                                                    INNER JOIN teachers t ON u.user_id = t.user_id
                                                    WHERE t.teacher_id = $teacher_id";
                                    $teacher_result = mysqli_query($conn, $teacher_sql);
                                    $teacher_name = mysqli_fetch_assoc($teacher_result)['name'];



                                    echo "<tr>";
                                    echo "<td class='text-center'>" . $class_id . "</td>";
                                    echo "<td>" . $class_name . "</td>";
                                    echo "<td class='text-center'>" . $branch_name . "</td>";
                                    echo "<td class='text-center'>" . $teacher_name . "</td>";
                                    echo "<td class='text-center'>" . $created_at . "</td>";
                                        echo "<td class='text-center'>
                                            <button class='btn btn-warning btn-sm' 
                                                data-toggle='modal' 
                                                data-target='#editClassModal' 
                                                data-id='" . $class_id . "' 
                                                data-name='" . $class_name . "'>
                                                <i class='material-icons'>edit</i>
                                            </button>
                                            </a>
                                            <a href='delete_class.php?id=$class_id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete?\")'>
                                                <i class='material-icons'>delete</i>
                                            </a>
                                        </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No classes found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    </span>
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
   <!-- Edit Class Modal -->
   <div class="modal fade" id="editClassModal" tabindex="-1" role="dialog" aria-labelledby="editClassModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editClassModalLabel">Edit Class</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_class.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="class_id">Class Id</label>
                            <input type="text" name="class_id" id="edit_class_id" readonly class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="edit_class_name">Class Name</label>
                            <input type="text" class="form-control" name="class_name" id="edit_class_name" required>
                        </div>

                        <!-- Branch Selection -->
                        <div class="form-group">
                            <label for="edit_branch_id">Branch</label>
                            <select class="form-control" name="branch_id" id="edit_branch_id" required>
                                <?php
                                $branches = mysqli_query($conn, "SELECT * FROM branches");
                                while ($branch = mysqli_fetch_assoc($branches)) {
                                    echo "<option value='{$branch['branch_id']}'>{$branch['branch_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Teacher Selection -->
                        <div class="form-group">
                            <label for="edit_teacher_id">Class Teacher</label>
                            <select class="form-control" name="teacher_id" id="edit_teacher_id" required>
                                <?php
                                $teachers = mysqli_query($conn, "SELECT * FROM users WHERE role = 'teacher'");
                                while ($teacher = mysqli_fetch_assoc($teachers)) {
                                    echo "<option value='{$teacher['user_id']}'>{$teacher['name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    Branch details updated successfully.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script
        src="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {

            $('#editClassModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var classId = button.data('id');
                var className = button.data('name');
                var branchId = button.data('branch-id');
                var teacherId = button.data('teacher-id');

                var modal = $(this);
                modal.find('#edit_class_id').val(classId);
                modal.find('#edit_class_name').val(className);
                modal.find('#edit_branch_id').val(branchId);
                modal.find('#edit_teacher_id').val(teacherId);
            });


            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

            $('#branchesTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                initComplete: function () {
                    $('.dt-buttons .btn, .dt-buttons .dt-button').css({
                        'background-color': '#4CAF50',
                        'color': 'white',
                        'border': 'none',
                        'border-radius': '4px',
                        'padding': '6px 12px',
                        'font-size': '14px',
                        'margin': '0 4px',
                        'cursor': 'pointer'
                    }).hover(
                        function () { $(this).css('background-color', '#45a049'); },
                        function () { $(this).css('background-color', '#4CAF50'); }
                    );
                }
            });
        });
    </script>
</body>

</html>