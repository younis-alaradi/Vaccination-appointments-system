<?php
require "header.php";
?>

<br><br>
<div class="container">
    <h3 class="text-center"><br>View Appointments<br></h3>

    <?php
    if (isset($_SESSION['user_id'])) {
        echo '<p class="text-white bg-dark text-center">' . $_SESSION['username'] . ', here you can see all appointments history</p><br>';


        if (isset($_GET['delete'])) {
            if ($_GET['delete'] == "error") {
                echo '<h5 class="bg-danger text-center">Error!</h5>';
            }
            if ($_GET['delete'] == "success") {
                echo '<h5 class="bg-success text-center">Deleted successfully</h5>';
            }
        }
        require 'includes/view.appointments.inc.php';
    } else {
        echo '	<p class="text-center text-danger"><br>You are currently not logged in!<br></p>
       <p class="text-center">In order to make an appointment you have to log in!<br><br><p>';
    }
    ?>

</div>
<br><br>


<?php
require "footer.php";
?>