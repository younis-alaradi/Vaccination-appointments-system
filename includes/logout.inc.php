<?php
session_start();
//Kill the session here
/**
 * Logout process 
 * Author : Yonuis Alaradi 
 * Purpose : Killing the session upon user logout to avoid any errors might occur or any inpredictiable access 
*/
/*----------------LOGOUT PROCESS------------------*/
if (isset($_POST['logout-submit'])) {
    session_destroy(); // killing the session
}
/*----------------END - LOGOUT PROCESS------------*/


header("Location: ../index.php");
exit();
 