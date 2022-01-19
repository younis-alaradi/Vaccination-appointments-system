<head>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script><!-- custom pop-up framework -->
</head>
<?php
/**
 * Schedule page for Admins 
 * Author : Younis Alaradi 
 * purpose : Enable the adminstration's to add and manage the registered times 
*/

echo '<p class="text-white bg-dark text-center"> Welcome ' . $_SESSION['username'] . '</p><br>';
?>



<div class="container">

  <form action="" method="POST">
    <!-- From  time -->


    <div class="mb-3">
      <label for="From" class="form-label">From :</label>

      <input type="time" class="form-control" id="From" name="from_time">
      <div id="emailHelp" class="form-text">Please select start time (: !!!</div>
    </div>


    <!-- To time -->
    <div class="mb-3">
      <label for="To" class="form-label">To :</label>
      <input type="time" class="form-control" id="To" name="to_time">

      <div id="emailHelp" class="form-text">Please specify the end time (: !!!</div>
    </div>



    <!-- date  -->
    <div class="mb-3">
      <label for="Date" class="form-label">Date</label>
      <input type="date" class="form-control" id="Date" name="appointment_date">
      <div id="emailHelp" class="form-text">Please select the date (: !!! </div>


    </div>



    <button type="submit" class="btn btn-primary">Submit</button>


  </form>

</div>
</body>



<?php
$from = null;
$to = null;
$date = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_POST['from_time'])) {
    $from = $_POST['from_time'];

    if (!empty($_POST['to_time'])) {
      $to = $_POST['to_time'];

      if (!empty($_POST['appointment_date'])) {
        $date = $_POST['appointment_date'];
        require('includes/config.php');
        try {

          $con = new PDO(DBCONNSTRING, DBUSER, DBPASS);
          $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // using prepared statement to secure the system from SQL injection 
          $insertion = "INSERT INTO schedule (date, open_time, close_time, appointments) VALUES (?,?,?,0)";
          $state = $con->prepare($insertion);
          $state->bindValue(1, $date);
          $state->bindValue(2, $from);
          $state->bindValue(3, $to);
          $state->execute();


          // pop up a success message to the user 
          echo "<script> 
                        Swal.fire({
                        icon: 'success',
                         title: 'Your work has been saved , inserted successfully',
                        })
                        </script> ";

          $con = null; // kill the coonection 


        } catch (Exception $e) {
          echo "<script> 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '" . $e->getMessage() . "',
                      })
                    </script> ";
        }
      } // if date != empty 
      else {
        echo "<script> 
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please enter the date !',
                  })
                </script> ";
      }
    } // if to time != empty 
    else {
      echo "<script> 
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please enter the missed time !',
              })
            </script> ";
    } // if to time == empty 

  } // if not from time == empty 
  else {

    echo "<script> 
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Please enter the missed time !',
        })
      </script> ";
  } // from time == empty  
}

?>