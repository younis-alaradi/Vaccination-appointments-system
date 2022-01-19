<?php


//delete appointment

if (isset($_POST['delete-submit'])) {

    require 'config.php';
    try {
        /**
         * Delete the selected appointment 
         * Author : Hasan Fasial Kursheed 
         * Purpose : Enable users to delete the selected appointment as well as decrecment the number of appointment in schedule table
         */

        /*FUNCTION - This function is designed to return the appointment infomration and the reason 
        behind is here in this page , is to update the number of the appointments after the deletion*/
        /*----------------------------GET SCHEDULE DATA---------------------------------*/
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
        }
        /*----------------------------END - GET SCHEDULE DATA---------------------------------*/

        /*---------------Update schedule function - to update the number of appointments after the deletion of the exist appointmnet number be deduct 1 as a single appointment-------------------*/

        function UpdateScheduleTable($Appointments, $TheDate)
        {
            $SDB = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $SDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $updateSchedule = "UPDATE schedule SET `appointments`=? WHERE  `date`=?"; //sql statement 
            $Ustate = $SDB->prepare($updateSchedule); // preparing the sql statement to prevent injections 
            if ($Appointments <= 0) // simple condition to avoid misuse  & errors insertions 
                $Appointments = 0;
            $Ustate->bindValue(1, $Appointments); // binding the value 
            $Ustate->bindValue(2, $TheDate); // binding the value 2 
            $Ustate->execute(); // execute the statement ( debuge the statement - Operate )

            $SDB = null;
            return true;
        }
        /*-----------------------END - UPDATE SCHEUDLE----------------------------------*/

        /*
        write the code to delete the appointment        
        */
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*---------------------------------------|Take the data from schedule table|--------------------------------------------- */
        $dataSchedule = GetAppointments($_POST['date']); // fetching the data in attribute 
        $Num_OF_APP = $dataSchedule['appointments']; // fetching the appointments count in the attribute 
        $Num_OF_APP--; // deduct 1 from the total count  then update the schedule table again 
        /*---------------------------------------|END - Take the data from schedule table|-------------------------------------- */



        if (isset($_POST['id'])) { // if the Id not null then proceed 

            /*--------------------Delete the selected appointment--------------------*/
            $sql = "DELETE FROM `appointment` WHERE `id`=?"; // delete SQL statement 
            $state = $pdo->prepare($sql); // preparing the statement to the binding 
            $state->bindValue(1, $_POST['id']); // binding the value 

            /*------------------Update schedule table------------------------*/
            UpdateScheduleTable($Num_OF_APP, $dataSchedule['date']);
            /*------------------END - Update schedule table------------------------*/


            $state->execute(); // execute - operate the statement 
            $pdo = null;
            /*--------------------END - Delete the selected appointment--------------------*/


            /*-----------------------------Process to indicate the failure or success----------------*/
            if ($state->execute())
                header("Location: ../view_appointments.php?delete=success");
        } else {
            header("Location: ../view_appointments.php?delete=error");
        }
        /*-----------------------------END -Process to indicate the failure or success-----------*/
    } catch (PDOException $e) {
        header("Location: ../view_appointments.php?delete=error");
        exit();
    }//catch 
}//if submit $_POST 
