
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login</title>
    
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
        <!--Breadcrumb Section End Here-->


        <!--Contact Section Start Here-->
        <section class="contact-section padding-20" >
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 offset-md-3">
                        <div class="form-area">
                            <div class="form-bottom padding-top-30">
                                <div class="common-title">
                                    <h2 class="heading line-left">Login</h2>
                                </div>
                                <?php
                                    require_once 'login.php';

                                    // Create an instance of the Login class
                                    $login = new Login($conn);

                                    // Process login form submission
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                        $username = $_POST['username'];
                                        $password = $_POST['password'];

                                        if ($login->authenticate($username, $password)) {
                                            // Authentication successful
                                            // Start a session and store necessary session data
                                            session_start();
                                            $_SESSION['username'] = $username;

                                            // Redirect to admin dashboard or desired page
                                            header("Location:  admin_dashboard.php");
                                            exit;
                                        } else {
                                            // Authentication failed
                                            $error = "Invalid username or password";
                                            echo'<div class="alert alert-danger">'.$error.'</div>';
                                        }
                                    }
                                    if(isset($_GET['msg']) && $_GET['msg']=== 'success'){
                                        $error = "Accout created. Login to continues";
                                            echo'<div class="alert alert-danger">'.$error.'</div>';
                                    }
                                ?>
                                <div class="form">
                                    <form method="POST" action="index.php">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" class="form-control" id="username" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <p>Do not have an account? <a href="signup.php">Sign up</a></p>
                                        <div class="main-btn-wrap margin-top-40">
                                            <input class="main-btn" type="submit" value="Login">
                                        </div> 
                                    </form>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--Contact Section End Here-->


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