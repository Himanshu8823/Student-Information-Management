<?php
error_reporting(E_ALL ^ E_NOTICE);
if(!isset($_SESSION['user_id']))
{
    header('Location: teacher_login.php');
    exit();
}

?>

<div class="top-navbar">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                <span class="material-icons">arrow_back_ios</span>
            </button>

            <a class="navbar-brand" href="#"> Dashboard </a>

            <button class="d-inline-block d-lg-none ml-auto more-button" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="material-icons">more_vert</span>
            </button>
            <?php
                    $query = "SELECT * from users WHERE user_id = '".$_SESSION['user_id']."' ";
                    $result = mysqli_query($conn,$query);
                    $array = mysqli_fetch_assoc($result);

            ?>


            <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none"
                id="navbarSupportedContent">
                <ul class="nav navbar-nav ml-auto">
                <span class="pt-2 pr-2"><?php echo $array['name']; ?></span>

                    <li class="dropdown nav-item active">
                    
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            
                            <span class="material-icons" style="color:yellow">person</span>
                        </a>
                        <ul class="dropdown-menu">
                            
                            <li>
                                <a href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>