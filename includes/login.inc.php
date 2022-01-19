<?php
if (isset($_POST['login-submit'])) {


    $uname = $_POST['uname'];
    $password = $_POST['password'];


    if (empty($uname) || empty($password)) {
        header("Location: ../index.php?error1=emptyfields");
        exit();
    } else {

        require 'config.php';

        try {
            /*----------------------LOGIN VALIDATION PROCESS----------------------- */
            // protecting the system using prepared statement to prevent SQL injection 
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM users WHERE uname=? OR email=?";
            $state = $pdo->prepare($sql);
            $state->bindValue(1, $uname);
            $state->bindValue(2, $uname);
            $state->execute();

            // $result = $pdo->query($sql);

            /* in the signup there is a random salt function that insert random stings , then concatenate 
             the digest with password to be highely secured*/

            $pdo = null;

            if ($row = $state->fetch()) {


                // hashing the password 
                if ($row['role_id'] == 2) {
                    $hashed_password = $password;
                    if ($row['uname'] != 'admin') {
                        //Hashing the password for adminstrations users 
                        $hashed_password = md5($password . $row['salt']);
                    }
                } else {
                    $hashed_password = md5($password . $row['salt']); // hashing the passowrd 
                }

                if ($hashed_password != $row['password']) {
                    header("Location: ../index.php?error1=wrongpwd");
                    exit();
                } else {
                    session_start();
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['username'] = $row['uname'];
                    $_SESSION['role'] = $row['role_id'];

                    header("Location: ../appointment.php?login=success");
                    exit();
                }
            } else {
                header("Location: ../index.php?error1=nouser");
                exit();
            }
            /*----------------------END LOGIN VALIDATION PROCESS----------------------- */
        } catch (PDOException $e) {
            header("Location: ../index.php?error1=error");
            exit();
        }
    }
} else {
    header("Location: ../index.php");
    exit();
}
