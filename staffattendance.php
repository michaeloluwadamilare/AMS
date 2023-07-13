<?php
require_once 'connection.php';
require_once 'staffclass.php';
require_once 'attendance_class.php';

// Start the session to access session data
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Create instances of the Staff and Attendance classes
$staff = new Staff($conn);
$attendance = new Attendance($conn);

// Get the list of staff members
$staffList = $staff->getAllStaff();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Staff Atendance</title>
    
    <!-- favicon -->
    <link rel="icon" href="favicon.png" sizes="20x20" type="image/png"> 
    <!-- flaticon -->
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <!-- Fonts Awesome Icons -->
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <!-- bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- animate -->
    <link rel="stylesheet" href="assets/css/animate.css">
    <!--Video Popup-->
    <link rel="stylesheet" href="assets/css/rpopup.min.css">     
    <!--Slick Carousel-->
    <link rel="stylesheet" href="assets/css/slick.css">    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- responsive Stylesheet -->
    <link rel="stylesheet" href="assets/css/responsive.css">
      
</head>
<body>
    <main>   

            
        <!--Breadcrumb Section Start Here-->
        <section class="breadcrumb-area padding-90" style="background-image: url(assets/img/bg/breadcrumb-bg.png)">
            <div class="container-fluid">        
                <div class="row">
                    <div class="breadcrumb-content">
                        <div class="col-12 px-0">
                            <div class="page-title">
                                <h1 class="heading-1">Attendance Management System</h1>
                            </div>
                        </div>
                        <!-- <ul class="page-list">
                            <li><a href="index.html">Home</a></li>
                            <li>Contact</li>
                        </ul>  -->
                    </div>
                </div>       
            </div>
        </section>
        <h2>Welcome, <?php echo $username; ?>!</h2>

        <!-- Add your admin dashboard content here -->
        <p>This is the admin dashboard. You can add your custom content and functionality here.</p>

        <a href="logout.php">Logout</a>



        <section class="contact-section padding-20" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 offset-md-2">
                        <div class="form-area">
                            <div class="form-bottom padding-top-30">
                                <h2>Staff Attendance</h2>

                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Mark Attendance</th>
                                    </tr>
                                    <?php foreach ($staffList as $staffMember) : ?>
                                        <tr>
                                            <td><?php echo $staffMember['id']; ?></td>
                                            <td><?php echo $staffMember['name']; ?></td>
                                            <td>
                                                <form method="POST" action="process_attendance.php">
                                                    <input type="hidden" name="staff_id" value="<?php echo $staffMember['id']; ?>">
                                                    <select name="attendance">
                                                        <option value="absent">Absent</option>
                                                        <option value="present">Present</option>
                                                    </select>
                                                    <input type="submit" class="btn btn-success" value="Submit">
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>


                            <a href="admin_dashboard.php">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- footer area start -->
    <footer class="footer-area">
        <div class="copyright-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="copyright-area-inner">
                            &copy; Copyright 2023 MichaelWeb - Made with <span class="coypright-icon"><i class="fas fa-heart"></i></span> by 
                            <a href="#" target="_blank">Michael</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer area end -->



    <!-- back to top area start -->
    <div class="back-to-top">
        <span class="back-top"><i class="flaticon-up-arrow"></i></span>
    </div>
    <!-- back to top area end -->    



    <!--Jquery-->
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <!--Jquery Migrate-->
    <script src="assets/js/jquery-migrate.min.js"></script> 
    <!--Jquery UI-->
    <script src="assets/js/jquery-ui.js"></script>   
    <!-- bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!--Waypoints-->
    <script src="assets/js/waypoints.min.js"></script>
    <!--Slick Carousel-->
    <script src="assets/js/slick.min.js"></script>
    <!-- wow -->
    <script src="assets/js/wow.min.js"></script>
    <!--Custom Select Box-->
    <script src="assets/js/selectbox.min.js"></script>
    <!--Custom Video Popup-->
    <script src="assets/js/jquery.rPopup.js"></script>
    <!-- countdown -->
    <script src="assets/js/jquery.countdown.min.js"></script> 
    <!--Counter--> 
    <script src="assets/js/jQuery.rcounter.js"></script>
    <!--Google Map API-->
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCVyNXoXHkqAwBKJaouZWhHPCP5vg7N0HQ&callback=initMap" async defer></script> -->
    <!-- google map activate js -->
    <script src="assets/js/goolg-map-activate.js"></script>
    <!-- imageloaded -->
    <script src="assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="assets/js/isotope.pkgd.min.js"></script>
    <!-- main js -->
    <script src="assets/js/main.js"></script>

</body>
</html>
