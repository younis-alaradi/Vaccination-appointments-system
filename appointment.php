<?php
require "header.php";
?>


<br><br>
<div class="container">
    <h3 class="text-center"><br>New Appointment<br></h3>
    <div class="row">
        <div class="col-md-6 offset-md-3">



            <?php

            //check if user is logged in
            if (isset($_SESSION['user_id'])) {
                echo '<p class="text-white bg-dark text-center">Welcome ' . $_SESSION['username'] . ', Create your appointment here!</p>';

                //error handling:    
                if (isset($_GET['error3'])) {
                    if ($_GET['error3'] == "emptyfields") {
                        echo '<h5 class="bg-danger text-center">Fill all fields, Please try again!</h5>';
                    } else if ($_GET['error3'] == "invalidfname") {
                        echo '<h5 class="bg-danger text-center">First name must be 2-20 characters long!</h5>';
                    } else if ($_GET['error3'] == "invalidlname") {
                        echo '<h5 class="bg-danger text-center">Last name must be 2-20 characters long!</h5>';
                    } else if ($_GET['error3'] == "invalidtele") {
                        echo '<h5 class="bg-danger text-center">Telephone must be 6-20 characters long!</h5>';
                    } else if ($_GET['error3'] == "invalidcomment") {
                        echo '<h5 class="bg-danger text-center">Comments must be less than 200 characters!</h5>';
                    } else if ($_GET['error3'] == "full") {
                        echo '<h5 class="bg-danger text-center">Appointments are full for this date, Please try for other dates!</h5>';
                    }
                }

                //appointment saved
                if (isset($_GET['appointment'])) {
                    if ($_GET['appointment'] == "success") {
                        echo '<h5 class="bg-success text-center">Your appointment is booked successfully!</h5>';
                    }
                }
                echo '<br>';

                //appointment form  
                echo '          
        <div class="signup-form">
            <form action="includes/appointment.inc.php" method="post">
                
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="fname" placeholder="First Name" required="required">
                    <small class="form-text text-muted">First name must be 2-20 characters long</small>
                </div>
                
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="lname" placeholder="Last Name" required="required">
                    <small class="form-text text-muted">Last name must be 2-20 characters long</small>
                </div>   
                
                <div class="form-group">
                    <label>Appointment Date</label>
                    <select class="form-control" name="date" required="required">
                    ';
                require 'includes/config.php';
                $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM schedule WHERE appointments < 20 ORDER BY date";
                $result = $pdo->query($sql);
                while ($row = $result->fetch()) {
                    echo "
                            <option>" . $row['date'] . "</option>
                            ";
                }
                $pdo = null;
                echo '
                    </select>
                </div>
                
                
                <div class="form-group">
                    <label>Appointment Time</label>
                    <select class="form-control" name="time">
                    ';
                for ($t = 7; $t <= 16; $t++) {
                    if ($t < 10) {
                        echo "
                            <option>0$t:00</option>
                            <option>0$t:30</option>
                            ";
                    } else {
                        echo "
                            <option>$t:00</option>
                            <option>$t:30</option>
                        ";
                    }
                }
                echo '
                    </select>
                </div>
                
                <div class="form-group">
                <label for="guests">Telephone Number</label>
                    <input type="telephone" class="form-control" name="tele" placeholder="Telephone" required="required">
                    <small class="form-text text-muted">Telephone must be 6-20 characters long</small>
                </div>
                <div class="form-group">
                <label>Comments</label>
                    <textarea class="form-control" name="comments" placeholder="Comments" rows="3"></textarea>
                    <small class="form-text text-muted">Comments must be less than 200 characters</small>
                </div>        
                <div class="form-group">
            <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                </div>
                <div class="form-group">
                <button type="submit" name="appoint-submit" class="btn btn-dark btn-lg btn-block">Submit Appointment</button>
                </div>
            </form>
            <br><br>
        </div>
        ';
        
            }

            //if user is not logged in
            else {
                echo '	<p class="text-center text-danger"><br>You are currently not logged in!<br></p>
       <p class="text-center">In order to make a appointment you have to log in!<br><br><p>';
            }
            ?>


        </div>
    </div>
</div>
<br><br>


<?php
require "footer.php";
?>