<?php
// header 
include_once('header.php');
/**
 * Schedule page 
 * Author : Younis Alaradi 
 * Purpose : Create a specific sector that enable the adminstration's to set and manage the schedule
 */
?>

<br><br>
<div class="container">
  <h3 class="text-center"><br>Schedule<br></h3>

  <?php



  if (!empty($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
    $role = $_SESSION['role'];

    if ($role == 2) {
      // print form and allow the admin to add the schedule 
      require('includes/schedule.inc.php');
    } else {
      echo '<p class="text-white bg-dark text-center"> Welcome ' . $_SESSION['username'] . ' ,these are the upcoming schedule available</p><br>';
      require('includes/schedule_users.inc.php');
    }
  } else {
    // if anyone try to access , or directly  open this page 
    echo '
      <p class="text-center text-danger"><br>You are currently not logged in!<br></p>
  <p class="text-center">In order to see a schedule you have to log in!<br><br><p>';
  }

  ?>

</div>
<?php
// footer 
include('footer.php');
?>