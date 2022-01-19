<?php
session_start();

function between($val, $x, $y)
{
    $val_len = strlen($val);
    return ($val_len >= $x && $val_len <= $y) ? TRUE : FALSE;
}

if (isset($_POST['appoint-submit'])) {

    require 'config.php';

    $user = $_SESSION['user_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $tele = $_POST['tele'];
    $comments = $_POST['comments'];



    if (empty($fname) || empty($lname) || empty($date) || empty($time) || empty($tele)) {
        header("Location: ../appointment.php?error3=emptyfields");
        exit();
    } else if (!preg_match("/^[a-zA-Z ]*$/", $fname) || !between($fname, 2, 20)) {
        header("Location: ../appointment.php?error3=invalidfname");
        exit();
    } else if (!preg_match("/^[a-zA-Z ]*$/", $lname) || !between($lname, 2, 40)) {
        header("Location: ../appointment.php?error3=invalidlname");
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $tele) || !between($tele, 6, 20)) {
        header("Location: ../appointment.php?error3=invalidtele");
        exit();
    } else if (!preg_match("/^[a-zA-Z 0-9]*$/", $comments) || !between($comments, 0, 200)) {
        header("Location: ../appointment.php?error3=invalidcomment");
        exit();
    } else {
        /**
         * inserting and updating tables - appointments - schedule 
         * author : Hasan Fasial Kursheed 
         * purpose : Enable users  to book appointment and increcment the number of appointment in schedule table 
        */

        /*---------------------------SIMPLE FUNCTION TO GET SCHEDULE DATA--------------------------------*/
        function getAppointments($Appoint_date)
        {

            $CDB = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $CDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $AppointementCountSQL = "SELECT * FROM schedule WHERE  date =?";
            $appoint_count = $CDB->prepare($AppointementCountSQL);
            $appoint_count->bindValue(1, $Appoint_date);
            $appoint_count->execute();
            $Data = $appoint_count->fetch();

            $CDB = null;
            return $Data;
        } // function to return the appointments data 
        /*---------------------------END - SIMPLE FUNCTION TO GET SCHEDULE DATA---------------------*/

        try {


            /*---------------------Return the appointments data---------------------------*/
            $data_Schedule = GetAppointments($date); // to pick the number of appointments 
            /*---------------------END Return the appointments data---------------------------*/


            // check the number of appointments available 
            if ($data_Schedule['appointments'] < 20) {
                /*---------------------------------INSERT NEW APPOINTMENTS--------------------------*/
                $con = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $insertAppointment = "INSERT INTO appointment (`f_name`, `l_name`, `date`, `time`, `telephone`, `comment`, `reg_date`, `user_id`) 
            VALUES (
                :n1,
                :n2,
                :dt,
                :ti,
                :tel,
                :comm,
                :reqDate,
                :useID
                )";
                /*Prepare the statement and secure the parameters 
                using prepared statement to avoid any critical issuse occur and securing the database*/
                $req__Date = date('Y-m-d H:i:s');
                $state = $con->prepare($insertAppointment);
                $state->bindValue(':n1', $fname);
                $state->bindValue(':n2', $lname);
                $state->bindValue(':dt', $date);
                $state->bindValue(':ti', $time);
                $state->bindValue(':tel', $tele);
                $state->bindValue(':comm', $comments);
                $state->bindValue(':reqDate', $req__Date);
                $state->bindValue(':useID', $user);
                $state->execute();
                /*---------------------------------END - INSERT NEW APPOINTMENTS--------------------------*/


                /*----------------------------UPDATE SCHEUDLE TABLE-----------------------------*/
                $updateSchedule = "UPDATE schedule SET `appointments`=? WHERE  `date` = ?";
                $Ustate = $con->prepare($updateSchedule);
                $appCOUNT = $data_Schedule['appointments'];
                $appCOUNT++;
                $Ustate->bindValue(1, $appCOUNT);
                $Ustate->bindValue(2, $date);
                $Ustate->execute();
                $con = null;
                // norify the user that he/she booked successfully 
                header("Location: ../appointment.php?appointment=success");
                /*----------------------------END - UPDATE SCHEUDLE TABLE-----------------------------*/
            } else {
                // if the day is full , notify the user 
                $con = null;
                header("Location: ../appointment.php?error3=full");
            }
            $con = null; // killing the connection  
        } catch (PDOException $e) {
            echo '<h5 class="bg-danger text-center">' . $e->getMessage() . ' </h5>';
            exit();
        }


        /*
        Add the appointment in the database.
        it should not add the appointment if the 20 limit is reached, give some message:
            header("Location: ../appointment.php?error3=full");
        if added successfully, 
            make sure to increment - by one - the "appointments" column in the schedule table for
            the selected date, then go back:
                header("Location: ../appointment.php?appointment=success");
        */
    }
}
