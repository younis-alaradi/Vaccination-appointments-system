<?php

/**
 * User schedule page 
 * Author  : Younis Alaradi 
 * Purpose : A simple page the provide the users with the available date without the ability to insert new date or modify the data 
 */

require 'includes/config.php';
/*---------------------------------SELECTION & FETCHING SCHEDULE DATA--------------------------------------------------------*/
$pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// using prepared statement to prevent any injections might occur 
$sql = "SELECT * FROM schedule";
// $result = $pdo->query($sql);
$pre = $pdo->query($sql);


echo "
<table class='table table-sm table-striped table-dark text-center'>
<thead>
<tr>
<th scope='row' colspan=4>Available Schedule</th>
</tr>
<tr>
<th scope='col'>Date</th>
<th scope='col'>Open Time</th>
<th scope='col'>Close Time</th>
<th scope='col'>Booked Appointments</th>
</tr>
</thead>
<tbody>
";
if ($pre->rowCount() > 0) {
  while ($row = $pre->fetch()) {
    echo "
   <tr>
   <th scope='row'><em>" . $row['date'] . "</em></th>
   <td>" . $row['open_time'] . "</td>
   <td>" . $row['close_time'] . "</td>
   <td>" . $row['appointments'] . "</td>
   </tr>";
  }
  /*-------------------------------- END -SELECTION & FETCHING SCHEDULE DATA--------------------------------------*/
}
/*------------------------IF THERE IS NOTHING PROCESS------------------------*/ 
else {
  //when no schedule found for the selected date
  echo "                   
  <tr>
 <th scope='row'><em>" . $date . "</em></th>
 <td>not available</td>
 <td></td>
 <td></td>
 </tr>";
}
/*------------------------END -  IF THERE IS NOTHING PROCESS------------------------*/ 

echo "        
</tbody>
</table>";

 