<?php
session_start();
error_reporting(E_ALL ^ E_NOTICE);

include('../connection/connect.php');
if (isset($_POST['submit'])) {
    $stuname = $_POST['stuname'];
    $stuemail = $_POST['stuemail'];
    $stuclass = $_POST['stuclass'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $stuid = $_POST['stuid'];
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $connum = $_POST['connum'];
    $altconnum = $_POST['altconnum'];
    $address = $_POST['address'];
    $eid = $_GET['editid'];
}
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
                    <h1 class="mt-5 text-gray text-center">Update Student Details</h1>
                    <?php
if (isset($_GET['id'])) {
    $eid = intval($_GET['id']);

    // SQL query to join tblstudent, classes, and branches
    $sql = "SELECT tblstudent.*, classes.class_name, classes.branch_id, branches.branch_name
            FROM tblstudent 
            JOIN classes ON tblstudent.class_id = classes.class_id
            JOIN branches ON classes.branch_id = branches.branch_id
            WHERE tblstudent.ID = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        // Binding the student ID parameter
        mysqli_stmt_bind_param($stmt, 'i', $eid);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "No student found with the provided ID.";
            exit();
        }
    } else {
        echo "Failed to prepare the SQL statement.";
        exit();
    }
} else {
    echo "No student ID provided.";
    exit();
}
?>
<form class="forms-sample" method="post" enctype="multipart/form-data" action="edit_process.php?id=<?php echo $eid; ?>">
    <div class="form-group">
        <label for="exampleInputName1">Student Name</label>
        <input type="text" name="stuname" value="<?php echo htmlentities($row['StudentName']); ?>"
               class="form-control" required="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Student Email</label>
        <input type="text" name="stuemail" value="<?php echo htmlentities($row['StudentEmail']); ?>"
               class="form-control" required="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Gender</label>
        <select name="gender" class="form-control" required="true">
            <option value="Male" <?php if ($row['Gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($row['Gender'] == 'Female') echo 'selected'; ?>>Female</option>
        </select>
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Date of Birth</label>
        <input type="date" name="dob" value="<?php echo htmlentities($row['DOB']); ?>"
               class="form-control" required="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Student ID</label>
        <input type="text" name="stuid" value="<?php echo htmlentities($row['StuID']); ?>"
               class="form-control" readonly="true">
    </div>

    <!-- Display the class and branch as readonly fields -->
    <div class="form-group">
        <label for="exampleInputName1">Class</label>
        <input type="text" name="class_name" value="<?php echo htmlentities($row['class_name']); ?>"
               class="form-control" readonly="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Branch</label>
        <input type="text" name="branch_name" value="<?php echo htmlentities($row['branch_name']); ?>"
               class="form-control" readonly="true">
    </div>

    <div class="form-group">
        <label for="exampleInputName1">Student Photo</label>
        <img src="https://wallpapers.com/images/hd/free-fire-dj-alok-neon-wave-9gm6bigk50x5z4ak.jpg"
             width="100" height="100" style="border-radius:100%">
        <a href="changeimage.php?editid=<?php echo $eid; ?>"> &nbsp; Edit Image</a>
    </div>

    <h3>Parents/Guardian's details</h3>
    <div class="form-group">
        <label for="exampleInputName1">Father's Name</label>
        <input type="text" name="fname" value="<?php echo htmlentities($row['FatherName']); ?>"
               class="form-control" required="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Mother's Name</label>
        <input type="text" name="mname" value="<?php echo htmlentities($row['MotherName']); ?>"
               class="form-control" required="true">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Contact Number</label>
        <input type="text" name="connum" value="<?php echo htmlentities($row['ContactNumber']); ?>"
               class="form-control" required="true" maxlength="10" pattern="[0-9]+">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Alternate Contact Number</label>
        <input type="text" name="altconnum" value="<?php echo htmlentities($row['AltenateNumber']); ?>"
               class="form-control" required="true" maxlength="10" pattern="[0-9]+">
    </div>
    <div class="form-group">
        <label for="exampleInputName1">Address</label>
        <textarea name="address" class="form-control" required="true"><?php echo htmlentities($row['Address']); ?></textarea>
    </div>

    <h3>Login details</h3>
    <div class="form-group">
        <label for="exampleInputName1">User Name</label>
        <input type="text" name="uname" value="<?php echo htmlentities($row['UserName']); ?>"
               class="form-control" readonly="true">
    </div>
            <div class="form-group">
                <label for="exampleInputName1">Password</label>
                <input type="text" name="password" value="<?php echo htmlentities($row['Password']); ?>"
                    class="form-control" readonly="true">
            </div>
    <center class="mb-4">
        <button type="submit" class="btn btn-success mr-2 mb-4" name="submit">Update</button>
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