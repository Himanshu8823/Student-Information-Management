<?php
session_start();

error_reporting(E_ALL ^ E_NOTICE);
include('../connection/connect.php');

// Fetch students for the dropdown
$students_query = "SELECT * FROM tblstudent";
$students_result = mysqli_query($conn, $students_query);

// Document type suggestions
$document_types = ['Aadhar Card', 'Marksheet', 'Caste Certificate', 'Non Creamy Certificate', 'Income Certificate'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>
            <div class="main-content">
                <div class="container bg-white">
                    <h1 class="mt-5 text-gray text-center">Add Student Document</h1>

                    <form class="forms-sample" method="post" action="add_document_process.php"
                        enctype="multipart/form-data">
                        <!-- Student Selection -->
                        <div class="form-group">
                            <label for="student_id">Student</label>
                            <select name="student_id" id="student_id" class="form-control" required>
                                <option value="">Select Student</option>
                                <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                                    <option value="<?php echo $row['ID']; ?>"><?php echo $row['StudentName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Document Type -->
                        <div class="form-group">
                            <label for="document_type">Document Type</label>
                            <input type="text" name="document_type" id="document_type" class="form-control" required
                                placeholder="Type or select a document type">
                        </div>

                        <!-- File Upload -->
                        <div class="form-group">
                            <label for="document_file">Upload Document</label>
                            <input type="file" name="document_file" id="document_file" class="form-control" required>
                        </div>

                        <center>
                            <button type="submit" name="submit" class="btn btn-success mr-2">Upload</button>
                        </center>
                    </form>
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6">
                                <p class="copyright d-flex justify-content-end">
                                    &copy 2024 Design by &nbsp; <a href="#">MP</a> &nbsp; BootStrap Admin Dashboard
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

    <!-- Initialize Select2 -->
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

        // Autocomplete for Document Type
        $(function () {
            var documentTypes = <?php echo json_encode($document_types); ?>;
            $("#document_type").autocomplete({
                source: documentTypes,
                minLength: 0, // Show all suggestions on focus
                select: function (event, ui) {
                    $(this).val(ui.item.value);
                }
            }).on('focus', function () {
                $(this).autocomplete('search', ''); // Show all suggestions on focus
            });
        });
    </script>
</body>

</html>