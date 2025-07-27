<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);
include('../connection/connect.php');

// Check if the search form is submitted
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
    // Fetch students based on the search query
    $students_query = "SELECT * FROM tblstudent WHERE StudentName LIKE '%$search_query%'";
} else {
    // If no search, fetch all students
    $students_query = "SELECT * FROM tblstudent";
}

$students_result = mysqli_query($conn, $students_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Documents</title>
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
                    <h1 class="mt-5 text-gray text-center">View Student Documents</h1>

                    <!-- Search Bar -->
                    <form method="post" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search for a student" value="<?php echo $search_query; ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Student List -->
                    <div class="list-group">
                        <?php while ($row = mysqli_fetch_assoc($students_result)) { ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span><?php echo $row['StudentName']; ?></span>
                                <a href="view_student_document.php?ID=<?php echo $row['ID']; ?>" class="btn btn-info">View Documents</a>
                            </div>
                        <?php } ?>
                    </div>
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
