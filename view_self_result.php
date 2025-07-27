<?php
include('connection/connect.php');
session_start();

// Fetch student ID from the URL
$student_id = intval($_SESSION['student_id']);

// Fetch student details and class information
$student_query = "
    SELECT 
        tblstudent.StudentName,
        tblstudent.StuID,
        classes.class_name,
        branches.branch_name
    FROM tblstudent
    INNER JOIN classes ON tblstudent.class_id = classes.class_id
    INNER JOIN branches ON classes.branch_id = branches.branch_id
    WHERE tblstudent.ID = $student_id
";

$student_result = mysqli_query($conn, $student_query);
$student_data = mysqli_fetch_assoc($student_result);

// Fetch the results for the student
$result_query = "
    SELECT 
        subjects.subject_name,
        results.marks,
        results.total_marks
    FROM results
    INNER JOIN subjects ON results.subject_id = subjects.subject_id
    WHERE results.ID = $student_id
";

$result = mysqli_query($conn, $result_query);
$total_marks_obtained = 0;
$total_marks_out_of = 0;
$subjects_count = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Result</title>
    <link rel="stylesheet" href="admin/css/bootstrap.min.css">
    <style>
        .marksheet-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 2px solid #000;
            border-radius: 8px;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
        }
        .college-name {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        .marksheet-title {
            text-align: center;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .student-info, .result-table {
            margin-bottom: 20px;
        }
        .result-table th, .result-table td {
            text-align: center;
            padding: 10px;
        }
        .result-table tfoot {
            font-weight: bold;
        }
        .summary-section {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
        .printbtn
        {
            color:white;
            background-color: green;
            margin-bottom: 20%;
            margin-top: 5%;
            font-size: 40px;
            border-radius: 10px;

        }
        .printbtn:hover{
            background-color: greenyellow;
            cursor: pointer;
        }
    </style>
</head>

<body style="margin-top:4%">
    <div class="marksheet-container">
        <div class="college-name">
            G.H. Raisoni College of Engineering and Management, Jalgaon
        </div>
        <div class="marksheet-title">Student Marksheet</div>

        <div class="student-info">
            <p><strong>Student Name:</strong> <?php echo $student_data['StudentName']; ?></p>
            <p><strong>Roll Number:</strong> <?php echo $student_data['StuID']; ?></p>
            <p><strong>Class:</strong> <?php echo $student_data['class_name']; ?></p>
            <p><strong>Branch:</strong> <?php echo $student_data['branch_name']; ?></p>
        </div>

        <table class="table table-bordered result-table">
            <thead class="thead-dark">
                <tr>
                    <th>Subject</th>
                    <th>Marks Obtained</th>
                    <th>Total Marks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { 
                    $total_marks_obtained += $row['marks'];
                    $total_marks_out_of += $row['total_marks'];
                    $subjects_count++;
                ?>
                <tr>
                    <td><?php echo $row['subject_name']; ?></td>
                    <td><?php echo $row['marks']; ?></td>
                    <td><?php echo $row['total_marks']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total</strong></td>
                    <td><?php echo $total_marks_obtained; ?></td>
                    <td><?php echo $total_marks_out_of; ?></td>
                </tr>
            </tfoot>
        </table>

        <?php 
        // Calculate CGPA
        $cgpa = $subjects_count > 0 ? round(($total_marks_obtained / $total_marks_out_of) * 10, 2) : 0;
        ?>

        <div class="summary-section">
            <p><strong>CGPA:</strong> <?php echo $cgpa; ?></p>
        </div>
    </div>

    <center>
        <button id="printbtn" class="printbtn" type="button" onclick="printResult()">Print</button>
    </center>
    <script>
        var printBtn = document.getElementById('printbtn');
        function printResult() {
            printBtn.style.display='None';
            window.print();
        }
    </script>

</body>

</html>
;