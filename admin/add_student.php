<?php
session_start();
error_reporting(0);
include('../connection/connect.php');

error_reporting(E_ALL ^ E_NOTICE);
// Fetch branches for the dropdown
$branch_sql = "SELECT * FROM branches";
$branch_result = mysqli_query($conn, $branch_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.datatables.net/v/dt/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/r-3.0.3/datatables.min.css" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <?php include("sidebar.php"); ?>
        <div id="content">
            <?php include("header.php"); ?>
            <div class="main-content">
                <div class="container bg-white">
                    <h1 class="mt-5 text-gray text-center">Add New Student</h1>

                    <form class="forms-sample" method="post" action="add_student_process.php">
                        <div class="form-group">
                            <label for="exampleInputName1">Student Name</label>
                            <input type="text" name="stuname" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Student Email</label>
                            <input type="email" name="stuemail" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Gender</label>
                            <select name="gender" class="form-control" required="true">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="example InputName1">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Father's Name</label>
                            <input type="text" name="fname" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Mother's Name</label>
                            <input type="text" name="mname" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Contact Number</label>
                            <input type="text" name="connum" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Alternate Number</label>
                            <input type="text" name="altconnum" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Address</label>
                            <textarea name="address" class="form-control" required="true"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Username</label>
                            <input type="text" name="uname" class="form-control" required="true">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Password</label>
                            <input type="password" name="password" class="form-control" required="true">
                        </div>
                        
                        <!-- Branch Selection -->
                        <div class="form-group">
                            <label for="branch_id">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-control" required="true">
                                <option value="">Select Branch</option>
                                <?php while ($branch_row = mysqli_fetch_assoc($branch_result)) { ?>
                                    <option value="<?php echo $branch_row['branch_id']; ?>"><?php echo $branch_row['branch_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- Class Selection (dynamically populated based on branch) -->
                        <div class="form-group">
                            <label for="class_id">Class</label>
                            <select name="class_id" id="class_id" class="form-control" required="true">
                                <option value="">Select Class</option>
                            </select>
                        </div>

                        <center>
                            <button type="submit" name="submit" class="btn btn-success mr-2">Submit</button>
                        </center>
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

    <script type="text/javascript">
        // AJAX to populate classes based on selected branch
        $(document).ready(function () {
            $('#branch_id').change(function () {
                var branch_id = $(this).val();  // Get selected branch_id
                if (branch_id) {
                    $.ajax({
                        type: 'POST',
                        url: 'get_classes.php',  // PHP script to fetch classes
                        data: {branch_id: branch_id},
                        success: function (data) {
                            $('#class_id').html(data);  // Populate the classes dropdown
                        }
                    });
                } else {
                    $('#class_id').html('<option value="">Select Class</option>');  // Clear the class dropdown
                }
            });
        });
    </script>
</body>

</html>
