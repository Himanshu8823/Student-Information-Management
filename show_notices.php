<?php
session_start();
error_reporting(0);
include('connection/connect.php');

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch notices from the database
$sql = "SELECT * FROM notices ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$notices = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Notices</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .notices-wrapper {
            padding: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .notice-card {
            width: 300px;
            padding: 20px;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.1);
            transform: perspective(600px) rotateX(10deg);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid #ddd;
        }

        .notice-card:hover {
            transform: perspective(600px) rotateX(0deg);
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.2);
        }

        .notice-card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .notice-card p {
            color: #555;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .notice-card time {
            font-size: 0.85rem;
            color: #888;
            font-style: italic;
        }

        .notice-card .notice-content {
            margin-bottom: 10px;
            font-size: 1rem;
            color: #333;
        }

        .notice-card .notice-title {
            font-size: 1.5rem;
            color: #007bff;
            font-weight: 500;
            margin-bottom: 15px;
        }

        .notice-card .created-at {
            font-size: 0.85rem;
            color: #888;
            font-style: italic;
        }

        @media (max-width: 768px) {
            .notice-card {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container mt-5">
        <h1 class="text-center text-dark mb-4">Notices</h1>
        <div class="notices-wrapper">
            <?php if (!empty($notices)) : ?>
                <?php foreach ($notices as $notice) : ?>
                    <div class="notice-card">
                        <div class="notice-title">
                            <h3><?php echo htmlentities($notice['notice_title']); ?></h3>
                        </div>
                        <div class="notice-content">
                            <p><?php echo nl2br(htmlentities($notice['content'])); ?></p>
                        </div>
                        <div class="created-at">
                            <time>Posted on: <?php echo date('d M Y, h:i A', strtotime($notice['created_at'])); ?></time>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="notice-card">
                    <h3>No Notices Found</h3>
                    <p>There are no notices available at the moment. Please check back later.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>
