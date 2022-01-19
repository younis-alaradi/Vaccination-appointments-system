<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon.png">
    <title>Vaccination Appointment System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!--style.css document-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!--bootstrap-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!--googleapis jquery-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--font-awesome-->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <!--bootstrap-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <!--bootstrap-->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <!--bootstrap-->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- custom pop-up framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>



</head>


<?php
// assign the new color and create the cookie 

// testing the change color 
/**
 * Author : Samirul mohammed Rashod 
 *  Saving system theme using cookies and color picker 
 */
if (isset($_GET['Background-color'])) {
    $backColor = $_GET['Background-color'];
    echo '<body style="background-color:' . $backColor . ' ">';

    $expiryDate = time() + 60 * 60 * 24 * 2; // setting two days to delete the cookie 
    setcookie("ColorPreference", $backColor, $expiryDate);
} else if (isset($_COOKIE['ColorPreference'])) {
    $backColor = $_COOKIE['ColorPreference'];
    echo '<body style="background-color:' . $backColor . ' ">';
}


?>


<!---navbar--->
<nav class="navbar navbar-expand-md navbar-light fixed-top" id="NAV">
    <div class="container" id="navContainer">
        <a class="navbar-brand" id="navBrand" href="index.php">
            <strong><em>Vaccination Appointment System</em></strong>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navi">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navi">
            <ul class="navbar-nav mr-auto">
                <?php
                //navigation bar when logged in
                if (isset($_SESSION['user_id'])) {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="appointment.php" >New Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_appointments.php" >View Appointments</a>
                        </li>';

                    /*-------------------------------------EDITING THE MENU OPTION  FOR BOTH USERS ---------------------------------------------*/
                    $role = $_SESSION['role'];

                    if ($role == 2) {
                        echo '                      
                        <li class="nav-item">
                            <a class="nav-link" href="schedule.php" >Edit Schedule</a>
                        </li>
                        ';
                    } else {
                        echo '                      
                        <li class="nav-item">
                            <a class="nav-link" href="schedule.php" >View Schedule</a>
                        </li>
                        ';
                    }
                    /*------------------------------------- END - EDITING THE MENU OPTION  FOR BOTH USERS ---------------------------------------------*/
                }
                //navigation bar when not logged in
                else {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#aboutus">About Us</a>
	                    </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#gallery">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#appointment">Appointment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#footer">Find Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php#vaccinesInfo">Vaccines informations</a>
                        </li>
                        <li class="nav-item">
                                  <form class="row g-3" action="" method="GET">
                                       <a class="nav-link"><input type="color"name="Background-color" onchange="this.form.submit()" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Background Color"></a>
                                  </form>
                        </li>
                        <!--<li>-->
                        <!--<button onclick=" darkMode()" name="darkMode" value ="text-white bg-dark">Dark mode</button>-->
                        <!--</li>-->
                    ';
                }
                ?>

                <!-- Modal -->
                <script>
                    function darkMode() {
                        var element = document.body;
                        element.className = "text-white bg-dark";
                        /*-------------------------------------FIRST CONTAINER --------------------------------------------------- */
                        var first_container = document.getElementById('About-Container');
                        var vaccination_statics_btn = document.getElementById('vacc-statics-btn');
                        var offCanvas = document.getElementById('offcanvasRight');
                        var offCanvasBody = document.getElementById('offCanvas-body');
                        var offCanvas_items = document.getElementsByClassName("accordion-item");
                        var offCanvas_closeBTN = document.getElementById('close-offCanvas');

                        offCanvas_closeBTN.className = "text-reset btn-close btn-close-white";
                        for (var i = 0; i < offCanvas_items.length; i++) {
                            offCanvas_items[i].className = "accordion-item bg-dark";
                        }
                        offCanvasBody.className = "offcanvas-body bg-dark text-white";
                        offCanvas.className = "offcanvas offcanvas-end bg-dark text-white";
                        vaccination_statics_btn.className = "btn btn-outline-light btn-block btn-lg";
                        first_container.className = "container bg-dark text-white";
                        /*-------------------------------------END - FIRST CONTAINER --------------------------------------------------- */

                        /*-------------------------------------SECOND CONTAINER --------------------------------------------------- */
                        var second_container = document.getElementById('vaccinesInfo');
                        var accordionBTN = document.getElementsByClassName("accordion-button collapsed");
                        var accordionBody = document.getElementsByClassName('card-header');
                        var CardBody = document.getElementsByClassName('card-body');

                        for (var i = 0; i < CardBody.length; i++) {
                            CardBody[i].className = "card-body text-white bg-dark";
                        }

                        for (var i = 0; i < accordionBody.length; i++) {
                            accordionBody[i].className = "card-header  text-white bg-primary mb-3";
                        }
                        for (var i = 0; i < accordionBTN.length; i++) {
                            accordionBTN[i].className = "accordion-button collapsed  bg-dark text-white";
                        }
                        second_container.className = "container  bg-dark text-white";
                        /*-------------------------------------END - SECOND CONTAINER --------------------------------------------------- */
                        /*-------------------------------------Gallery CONTAINER --------------------------------------------------- */
                        var gallery = document.getElementById('gallery');
                        var galleryTitle = document.getElementById('gallery-title');
                        var firstTwo = document.getElementById('firstTwoGallery');
                        var remainFlex = document.getElementsByClassName('d-flex flex-column');
                        var GalleryContainer = document.getElementById('galleryContainer');

                        GalleryContainer.className = "container bg-dark text-white";
                        for (var i = 0; i < remainFlex.length; i++) {
                            remainFlex[i].className = "d-flex flex-column bg-dark";
                        }
                        firstTwo.className = "d-flex flex-row flex-wrap justify-content-center bg-dark";
                        galleryTitle.className = "text-center bg-dark text-white";
                        gallery.className = "bg-dark text-white";
                        /*-------------------------------------END - Gallery CONTAINER --------------------------------------------------- */
                        /*-------------------------------------APPOINTMENT CONTAINER --------------------------------------------------- */
                        var appoinContainer = document.getElementById('appointment');
                        var appointmentBTN = document.getElementById('makeAppoinBTN');
                        appointmentBTN.className = "btn btn-outline-light btn-block btn-lg";
                        appoinContainer.className = "container text-white bg-dark";
                        /*-------------------------------------END - APPOINTMENT CONTAINER --------------------------------------------------- */
                        /*-------------------------------------MAP CONTAINER --------------------------------------------------- */
                        var mapSection = document.getElementsByClassName('map');
                        var mapContainer = document.getElementById('mapContainer');
                        var mapContainerBtn = document.getElementById('checkSheduleMap');


                        mapContainerBtn.className = "btn btn-outline-light btn-block btn-lg";
                        mapContainer.className = "container text-white bg-dark";
                        for (var index = 0; index < mapSection.length; index++) {
                            mapSection[index].className = "map text-white bg-dark";
                        }
                        /*-------------------------------------END MAP CONTAINER --------------------------------------------------- */
                        /*-------------------------------------FOOTER --------------------------------------------------- */
                        var footer = document.getElementById('footer');
                        var footerContainer = document.getElementById('footerContainer');
                        footerContainer.className = "container text-white bg-dark";
                        footer.className = "footer text-white bg-dark";
                        /*-------------------------------------END FOOTER --------------------------------------------------- */
                        /*-------------------------------------Header --------------------------------------------------- */
                        var navBar = document.getElementById('NAV');
                        var navContainer = document.getElementById('navContainer');
                        var navTitle = document.getElementById('navBrand');
                        var navi = document.getElementById('navi');
                        var navigationItem = document.getElementsByClassName('nav-item');
                        var navigationLink = document.getElementsByClassName('nav-link');

                        for (var i = 0; i < navigationLink.length; i++)
                            navigationLink[i].className = "nav-link text-white bg-dark";
                        for (var index = 0; index < navigationItem.length; index++)
                            navigationItem[index].className = "nav-item text-white bg-dark";
                        navi.className = "collapse navbar-collapse text-white bg-dark";
                        navTitle.className = "navbar-brand text-white bg-dark";
                        navContainer.className = "container text-white bg-dark";
                        navBar.className = "navbar navbar-expand-md navbar-light fixed-top text-white bg-dark";
                        /*-------------------------------------END Header --------------------------------------------------- */

                    }
                </script>

            </ul>
            <div class="offcanvas" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasBottomLabel">Change Background Color</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body small">

                </div>
            </div>

            <!-- Modal -->





            <?php

            //log out button when user is logged in
            if (isset($_SESSION['user_id'])) {

                echo '
                    <form class="navbar-form navbar-right" action="includes/logout.inc.php" method="post">
                        <button type="submit" name="logout-submit" class="btn btn-outline-dark">Logout</button>
                    </form>';
            }
            //Sign Up and Login buttons when user is not logged in
            else {
                echo '
                    <div>
                        <ul class="navbar-nav ml-auto">
                            <li>
                                <a class="nav-link fa fa-sign-in"  data-toggle="modal" data-target="#myModal_reg">&nbsp;Sing Up</a>
                            </li>
                            <li>
                                <a class="nav-link fa fa-user-plus" data-toggle="modal" data-target="#myModal_login">&nbsp;Login</a>
                            </li>
                        </ul> 
                    </div>
                    ';
            }
            ?>

        </div>
    </div>
</nav>

<!-- Login screen -->
<div class="container">
    <!-- The Modal -->
    <div class="modal fade" id="myModal_login">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Login</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <?php
                    if (isset($_GET['error1'])) {

                        //script for modal to appear when error 
                        echo '  <script>
                    $(document).ready(function(){
                    $("#myModal_login").modal("show");
                    });
                    </script> ';


                        //error handling of log in

                        if ($_GET['error1'] == "emptyfields") {
                            echo '<h5 class="text-danger text-center">Fill all fields, Please try again!</h5>';
                        } else if ($_GET['error1'] == "error") {
                            echo '<h5 class="text-danger text-center">Error Occured, Please try again!</h5>';
                        } else if ($_GET['error1'] == "wrongpwd") {
                            echo '<h5 class="text-danger text-center">Wrong Password, Please try again!</h5>';
                        } else if ($_GET['error1'] == "error2") {
                            echo '<h5 class="text-danger text-center">Error Occured, Please try again!</h5>';
                        } else if ($_GET['error1'] == "nouser") {
                            echo '<h5 class="text-danger text-center">Username or email not found, Please try again!</h5>';
                        }
                    }
                    echo '<br>';
                    ?>

                    <div class="signin-form">
                        <form action="includes/login.inc.php" method="post">
                            <p class="hint-text">If you have already an account please log in.</p>
                            <div class="form-group">
                                <input type="text" class="form-control" name="uname" placeholder="Username Or Email" required="required">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login-submit" class="btn btn-dark btn-lg btn-block">Log In</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sign Up screen -->
<div class="container">
    <!-- The Modal -->
    <div class="modal fade" id="myModal_reg">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Register</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">

                    <?php
                    if (isset($_GET['error'])) {
                        //script for modal to appear when error 
                        echo '  <script>
                                $(document).ready(function(){
                                $("#myModal_reg").modal("show");
                                });
                            </script> ';


                        //error handling for errors and success --sign up form

                        if ($_GET['error'] == "emptyfields") {
                            echo '<h5 class="bg-danger text-center">Fill all fields!</h5>';
                        } else if ($_GET['error'] == "invalidemailusername") {
                            echo '<h5 class="bg-danger text-center">Username or Email are taken!</h5>';
                        } else if ($_GET['error'] == "invalidemail") {
                            echo '<h5 class="bg-danger text-center">Invalid Email, Please try again!</h5>';
                        } else if ($_GET['error'] == "usernameemailtaken") {
                            echo '<h5 class="bg-danger text-center">Username or email is taken, Please try again!</h5>';
                        } else if ($_GET['error'] == "invalidusername") {
                            echo '<h5 class="bg-danger text-center">Username must be 4-20 characters long!</h5>';
                        } else if ($_GET['error'] == "invalidpassword") {
                            echo '<h5 class="bg-danger text-center">Password must be 6-20 characters long!</h5>';
                        } else if ($_GET['error'] == "passworddontmatch") {
                            echo '<h5 class="bg-danger text-center">Passwords must match, Please try again!</h5>';
                        } else if ($_GET['error'] == "error1") {
                            echo '<h5 class="bg-danger text-center">Error Occured, Try again!</h5>';
                        } else if ($_GET['error'] == "error2") {
                            echo '<h5 class="bg-danger text-center">Error Occured, Try again!</h5>';
                        }
                    }
                    if (isset($_GET['signup'])) {
                        //script for modal to appear when success
                        echo '  <script>
                                $(document).ready(function(){
                                $("#myModal_reg").modal("show");
                                });
                            </script> ';

                        if ($_GET['signup'] == "success") {
                            echo '<h5 class="bg-success text-center">Sign up was successfull! Please Log in!</h5>';
                        }
                    }
                    echo '<br>';
                    ?>

                    <!---sign up form -->
                    <div class="signup-form">
                        <form action="includes/signup.inc.php" method="post">
                            <p class="hint-text">Create your account. It's free and only takes a minute.</p>
                            <div class="form-group">
                                <input type="text" class="form-control" name="uid" placeholder="Username" required="required">
                                <small class="form-text text-muted">Username must be 4-20 characters long</small>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="mail" placeholder="Email" required="required">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="pwd" placeholder="Password" required="required">
                                <small class="form-text text-muted">Password must be 6-20 characters long</small>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="pwd-repeat" placeholder="Confirm Password" required="required">
                            </div>
                            <div class="form-group">
                                <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="signup-submit" class="btn btn-dark btn-lg btn-block">Register Now</button>
                            </div>
                        </form>
                        <div class="text-center">Already have an account? <a class="nav-link" data-toggle="modal" data-target="#myModal_login" data-dismiss="modal">&nbsp;Login</a></div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>