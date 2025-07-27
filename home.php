<?php
include("connection/connect.php");
include('header.php');

if(!isset($_SESSION['student_id']))
{
    header("location:student_login.php");
    exit();
}
?>

<!-- AOS Library for Animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<style>
    /* Add 3D effect to cards */
    .card-3d {
        perspective: 1000px;
        /* Define the perspective for 3D */
    }

    .card-3d-content {
        transform-style: preserve-3d;
        transition: transform 0.5s ease;
    }

    .card-3d:hover .card-3d-content {
        transform: rotateY(15deg) rotateX(10deg);
        /* Rotate on hover for 3D effect */
    }

    .card-3d img {
        transition: transform 0.5s ease;
    }

    .card-3d:hover img {
        transform: scale(1.05);
        /* Zoom effect on hover */
    }

    /* Responsive design and spacing */
    .carousel-inner img {
        object-fit: cover;
        height: 600px;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        padding: 20px;
        border-radius: 10px;
    }

    .container .text-center {
        margin-bottom: 20px;
    }

    /* Notices Section Styling */
    #notices-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
    }

    .notices-wrapper {
    overflow-y: auto; /* Enable smooth scrolling */
    position: relative;
    max-height: 200px; /* Allow max visible height */
}

.notice {
    padding: 15px;
    background-color: white;
    margin-bottom: 10px;
    border-radius: 8px;
    box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.1);
}


    .notice h5 {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .notice p {
        font-size: 0.9rem;
        color: #555;
    }

    /* Slide-down animation */
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }
</style>

<!-- Carousel Section -->
<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
            aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
            aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
            aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://png.pngtree.com/thumb_back/fh260/background/20240526/pngtree-asian-young-university-students-studying-together-sitting-at-desk-in-library-image_15731485.jpg"
                class="d-block w-100" alt="Slide 1">
            <div class="carousel-caption d-none d-md-block" data-aos="fade-right">
                <h5>Welcome to the Student Portal</h5>
                <p>Manage your profile, view attendance, and more.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://c0.wallpaperflare.com/preview/264/169/201/book-read-student-students.jpg"
                class="d-block w-100" alt="Slide 2">
            <div class="carousel-caption d-none d-md-block" data-aos="fade-left">
                <h5>Track Your Progress</h5>
                <p>View your academic achievements and milestones.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/1454360/pexels-photo-1454360.jpeg?cs=srgb&dl=pexels-expressivestanley-1454360.jpg&fm=jpg"
                class="d-block w-100" alt="Slide 3">
            <div class="carousel-caption d-none d-md-block" data-aos="fade-up">
                <h5>Stay Updated</h5>
                <p>Get the latest updates and notices from your college.</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php
                        $student_id= $_SESSION['student_id'];
                        $sql= "SELECT * from tblstudent where ID ='$student_id'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                    ?>
<!-- Content Section -->
<div class="container my-5">
    <h2 class="text-center mb-4" data-aos="fade-down">Welcome Back,<?php echo $row['StudentName']; ?></h2>
    <p class="text-center" data-aos="fade-down">
        This portal helps you manage all your academic information, including attendance, grades, and more.
    </p>
    <div class="row">
        <!-- Card 1 -->
        <div class="col-md-4 text-center" id="card1">
            <div class="card card-3d shadow-lg" data-aos="fade-right">
                <div class="card-3d-content">
                    <img src="https://wallpapers.com/images/high/dj-alok-free-fire-black-background-a9gh95ydiazakyj4.webp"
                        height="300" width="300" class="card-img-top" alt="Profile">
                    <div class="card-body">
                        <h5 class="card-title">Your Profile</h5>
                        <p class="card-text">View and update your personal details </p>
                        <a href="profile.php" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="col-md-4 text-center">
            <div class="card card-3d shadow-lg" data-aos="fade-up">
                <div class="card-3d-content">
                    <img src="https://t3.ftcdn.net/jpg/03/08/91/98/360_F_308919862_hgbRZeYvO348NYDH7AsQcQ7AHSDbNZ7u.jpg"
                        class="card-img-top" alt="Attendance" height="300" width="300">
                    <div class="card-body">
                        <h5 class="card-title">View Attendance</h5>
                        <p class="card-text">Check your attendance and ensure you're on track.</p>
                        <a href="view_self_attendance.php" class="btn btn-primary">View Attendance</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="col-md-4 text-center">
            <div class="card card-3d shadow-lg" data-aos="fade-left">
                <div class="card-3d-content">
                    <img src="https://m.media-amazon.com/images/I/517KT12eSRL.png" class="card-img-top" alt="Marks"
                        height="300" width="300">
                    <div class="card-body">
                        <h5 class="card-title">View Grades</h5>
                        <p class="card-text">Check your grades, CGPA, and performance over time.</p>
                        <a target="_BLANK" href="view_self_result.php" class="btn btn-primary">View Grades</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container my-5" id="notices-section">
    <h2 class="text-center mb-4" data-aos="fade-down">Latest Notices</h2>
    <div class="notices-wrapper">
        <?php
        // Database connection
        


        // Fetch notices from the database
        $sql = "SELECT notice_title, content FROM notices ORDER BY notice_id DESC LIMIT 4";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Loop through each notice
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="notice" data-aos="fade-down">
                    <h5>' . htmlspecialchars($row['notice_title']) . '</h5>
                    <p>' . htmlspecialchars($row['content']) . '</p>
                </div>';
            }
        } else {
            echo '<p class="text-center">No notices available.</p>';
        }

        $conn->close();
        ?>
    </div>
</div>
<?php
    include("footer.php");
?>


<!-- Include AOS and Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize AOS
    AOS.init({
        duration: 1000, // Animation duration
        once: true      // Animate only once
    });
</script><script>
    // Auto-scroll notices
    const wrapper = document.querySelector('.notices-wrapper');
    let scrollY = 0;

    setInterval(() => {
        scrollY += 1;
        if (scrollY >= wrapper.scrollHeight - wrapper.clientHeight) {
            scrollY = 0; // Reset scroll to top when reaching the end
        }
        wrapper.scrollTop = scrollY;
    }, 50); // Adjust scrolling speed by modifying the interval
</script>


</body>

</html>