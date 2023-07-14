<?php
require_once 'connection.php';
require_once 'staffclass.php';
require_once 'attendance_class.php';

// Start the session to access session data
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Create instances of the Staff and Attendance classes
$staff = new Staff($conn);
$attendance = new Attendance($conn);

// Get the list of all staff members
$staffList = $staff->getAllStaff();

// Get the attendance for the current month
$month = date('m');
$year = date('Y');
$attendanceData = $attendance->getAttendanceForMonth($month,$year);

// Calculate the salary to be paid
$totalSalary = 0;

$workingDays = getWorkingDaysInMonth($year, $month);

foreach ($staffList as $staffMember) {
    $salaryPerDay = $staffMember['monthly_salary'] / $workingDays;
    $attendanceCount = isset($attendanceData[$staffMember['id']]) ? count($attendanceData[$staffMember['id']]) : 0;
    $salary = $salaryPerDay * $attendanceCount;
    $totalSalary += $salary;

    // Update the staff member's salary in the database (if needed)
    //$staff->updateSalary($staffMember['id'], $salary);
}


function getWorkingDaysInMonth($year, $month) {
    $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $workingDays = 0;

    for ($day = 1; $day <= $totalDays; $day++) {
        $currentDate = date("Y-m-d", strtotime("$year-$month-$day"));
        $currentDayOfWeek = date("N", strtotime($currentDate));

        // Exclude weekends (Saturday and Sunday)
        if ($currentDayOfWeek >= 1 && $currentDayOfWeek <= 5) {
            $workingDays++;
        }
    }

    return $workingDays;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Admin</title>
    
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

<header>
        <div class="container-fluid">
          <div class="row">  
            <div class="header-area">
                <nav class="navbar navbar-area navbar-expand-lg">
                    <div class="container nav-container">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#fortis_main_menu" 
                            aria-expanded="false" aria-label="Toggle navigation">
                            <!-- <span class="navbar-toggler-icon"> </span> -->
                            <span class="cross-menu">
                                <span class="bar1"></span>
                                <span class="bar2"></span>
                                <span class="bar3"></span> 
                            </span>    
                        </button>
                        <div class="collapse navbar-collapse" id="fortis_main_menu">
                            <ul class="navbar-nav">
                                <li class=" current-menu-item"><a href="admin_dashboard.php">Staff Attendance Record</a></li>
                                <li class="">
                                    <a href="staffattendance.php">Mark Attendance</a>
                                </li>
                                <li><a href="logout.php">Logout</a></li>            
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>                  
          </div>
        </div>
    </header>    
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
        <section class="contact-section padding-20" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 offset-md-3">
                        <div class="form-area">
                            <h2>Attendance Report For <?php echo date('F') ?></h2>

                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>Staff ID</th>
                                    <th>Name</th>
                                    <th>Absent Days</th>
                                    <th>Actual Salary(&#8358;)</th>
                                    <th>Salary Deduction(&#8358;)</th>
                                    <th>Paid Salary(&#8358;)</th>
                                </tr>
                                <?php foreach ($staffList as $staffMember) : ?>
                                    <tr>
                                        <td><?php echo $staffMember['id']; ?></td>
                                        <td><?php echo $staffMember['name']; ?></td>
                                        <td><?php echo isset($attendanceData[$staffMember['id']]) ? count($attendanceData[$staffMember['id']]) : 0; ?></td>
                                        <td><?php echo $staffMember['monthly_salary']; ?></td>
                                        <td>
                                            <?php 
                                            $absent_salary =  number_format($salaryPerDay * (isset($attendanceData[$staffMember['id']]) && is_array($attendanceData[$staffMember['id']]) ? count($attendanceData[$staffMember['id']]) : 0), 2); 
                                            echo $absent_salary;
                                            ?>
                                        </td>
                                        <td><?php echo number_format(($staffMember['monthly_salary'] - $absent_salary), 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
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
