<?php
include('../connection/connect.php');
session_start();
error_reporting(E_ALL ^ E_NOTICE);

$sql_notices = "SELECT * FROM notices";
$result_notices = mysqli_query($conn, $sql_notices);
$data = null;
$data_name = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View notices</title>
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
                    <h1 class="mt-5 text-gray text-center">View notices</h1>
                    <div class="d-flex justify-content-end mt-4">
                        <div id="tableButtons" class="mb-3"></div>
                    </div>
                    <div class="table-responsive">
                    <table id="noticesTable" class="table  table-striped table-bordered mt-4 mb-4 pb-4">
                        <thead>
                            <tr>
                                <th class="text-center">notice ID</th>
                                <th class="text-center">notice Name</th>
                                <th class="text-center">Notice Content</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_notices && mysqli_num_rows($result_notices) > 0) {
                                while ($row = mysqli_fetch_assoc($result_notices)) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>" . $row['notice_id'] . "</td>";
                                    echo "<td>" . $row['notice_title'] . "</td>";
                                    echo "<td>" . $row['content'] . "</td>";
                                    echo "<td class='text-center'>
                <button class='btn btn-warning btn-sm' 
                        data-toggle='modal' 
                        data-target='#editnoticeModal' 
                        data-id='" . $row['notice_id'] . "' 
                        data-name='" . $row['notice_title'] . "'
                        data-content='" . $row['content'] . "'
                        >
                        <i class='material-icons'>edit</i>
                    </button>
                <a href='delete_notice.php?id=" . $row['notice_id'] . "' 
                   class='btn btn-danger btn-sm' 
                   onclick='return confirm(\"Are you sure you want to delete?\")'>
                   <i class='material-icons'>delete</i>
                </a>
              </td>";
                                    echo "</tr>";


                                }
                            } else {
                                echo "<tr><td colspan='3'>No notices found.</td></tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    </div>
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

    <div class="modal fade" id="editnoticeModal" tabindex="-1" role="dialog" aria-labelledby="editnoticeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editnoticeModalLabel">Edit notice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_notice.php" method="POST">
                    <div class="modal-body">
                        <!-- Read-only notice ID -->
                        <input type="text" name="notice_id" id="notice_id" readonly class="form-control mb-3">

                        <!-- notice Name Field -->
                        <div class="form-group">
                            <label for="notice_name">notice Name</label>
                            <input type="text" class="form-control" name="notice_name" id="notice_name" required ">
                        </div>
                        <div class="form-group">
                            <label for="notice_content">notice Name</label>
                            <input type="text" class="form-control" name="notice_content" id="notice_content" required ">
                        </div>
                    </div>
                    <div class=" modal-footer">
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
                    notice details updated successfully.
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


            $('#editnoticeModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);  // This refers to the button that triggers the modal
                var noticeId = button.data('id');    // Extract notice ID from the data-id attribute
                var noticeName = button.data('name'); // Extract notice name from the data-name attribute
                var content = button.data('content');
                // Log to confirm the values
                console.log('notice ID:', noticeId);
                console.log('notice Name:', noticeName);

                var modal = $(this); // Reference the modal itself
                modal.find('#notice_id').val(noticeId);  // Set the notice ID in the readonly input field
                modal.find('#notice_name').val(noticeName); // Set the notice name in the input field
                modal.find('#notice_content').val(content); 
            });


            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

            $('#noticesTable').DataTable({
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