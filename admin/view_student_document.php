<?php
session_start();
include('../connection/connect.php');
error_reporting(E_ALL ^ E_NOTICE);

// Check if the student ID is provided in the query string
if (isset($_GET['ID'])) {
    $student_id = mysqli_real_escape_string($conn, $_GET['ID']);

    // Fetch student details
    $student_query = "SELECT * FROM tblstudent WHERE ID = '$student_id'";
    $student_result = mysqli_query($conn, $student_query);
    $student = mysqli_fetch_assoc($student_result);

    // Fetch documents for the student
    $documents_query = "SELECT * FROM documents WHERE ID = '$student_id'"; // Ensure correct field for relation
    $documents_result = mysqli_query($conn, $documents_query);
} else {
    // Redirect if no student ID is provided
    header("Location: view_documents.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Documents</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>
            <div class="main-content">
                <div class="container bg-white">
                    <h1 class="mt-5 text-gray text-center">Documents for <?php echo $student['StudentName']; ?></h1>

                    <!-- Student Details -->
                    <div class="mb-4">
                        <h5><strong>Name:</strong> <?php echo $student['StudentName']; ?></h5>
                        <p><strong>Email:</strong> <?php echo $student['StudentEmail']; ?></p>
                    </div>

                    <!-- Documents List -->
                    <h3 class="mb-4">Documents</h3>
                    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Document Type</th>
                <th>View Document</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if (mysqli_num_rows($documents_result) > 0) {
                while ($document = mysqli_fetch_assoc($documents_result)) { ?>
                    <tr>
                        <td><?php echo $document['document_type']; ?></td>
                        <td>
                            <a href="<?php echo $document['document_file']; ?>" class="btn btn-info" target="_blank">
                                View Document
                            </a>
                        </td>
                        <td>
                            <a href="<?php echo $document['document_file']; ?>" class="btn btn-success" download>
                                Download
                            </a>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td colspan="3" class="text-center">No documents available for this student.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <p class="copyright d-flex justify-content-end">
                                    &copy; 2024 Design by &nbsp; <a href="#">MP</a> &nbsp; BootStrap Admin Dashboard
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

   
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
                $('#content').toggleClass('active');
            });

            $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });

            $('#student_id').select2({
                placeholder: "Select a student",
                allowClear: true
            });
        });
    </script>
</body>

</html>
