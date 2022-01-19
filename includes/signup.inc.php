<?php


function between($val, $x, $y)
{
    $val_len = strlen($val);
    return ($val_len >= $x && $val_len <= $y) ? TRUE : FALSE;
}

if (isset($_POST['signup-submit'])) {


    require 'config.php';

    $username = $_POST['uid'];
    $email = $_POST['mail'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd-repeat'];


    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../index.php?error=emptyfields");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../index.php?error=invalidemailusername");
        exit();
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.php?error=invalidemail");
        exit();
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $username) || !between($username, 4, 20)) {
        header("Location: ../index.php?error=invalidusername");
        exit();
    } else if (!between($password, 6, 20)) {
        header("Location: ../index.php?error=invalidpassword");
        exit();
    } else if ($password !== $passwordRepeat) {
        header("Location: ../index.php?error=passworddontmatch");
        exit();
    } else {
        /**
         * Sign up 
         * Author : Younis Alaradi 
         * Purpose : Enable users to sign up within the system as well as using specific techniques to secure users password 
         */
        //function to create random salt 
        /**
         * Reference of the function  that provide random salt: https://gist.github.com/cballou/2195438 
         */
        /*----------------------RANDOM SALT FUNCTION ---------------------------*/
        function RandomSalt($len = 8)
        {
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
            $l = strlen($chars) - 1;
            $str = '';
            for ($i = 0; $i < $len; ++$i) {
                $str .= $chars[rand(0, $l)];
            }
            return $str;
        }
        /*----------------------END - RANDOM SALT FUNCTION ---------------------------*/


        try {
            /*---------------------------SIGN UP & HASHING THE PASSWORD----------------------------*/
            $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM users WHERE uname=? OR email=?";
            $s = $pdo->prepare($sql);
            $s->bindValue(1, $username);
            $s->bindValue(2, $username);
            $s->execute();
            // securing system using prepared statement to prevent sql injection 
            //$result = $pdo->query($sql);


            //$result->fetch(
            if ($row = $s->fetch()) {
                $pdo = null;
                header("Location: ../index.php?error=usernameemailtaken");
                exit();
            } else {

                // secure the system using prepared statement 
                $Random_salt = RandomSalt(8);
                $sql = "INSERT INTO users(uname, email, password,salt) VALUES(?,?,?,?)";
                $state = $pdo->prepare($sql);
                $state->bindValue(1, $username);
                $state->bindValue(2, $email);
                //hashing the password 
                // integrate random salt with the password to be hashed 
                $Hpassowrd = md5($password .$Random_salt) ;
                $state->bindValue(3, $Hpassowrd);
                // adding the random salt 
                $state->bindValue(4, $Random_salt);
                $state->execute();

                //$count = $pdo->exec($sql);

                if ($state == 1) {
                    $pdo = null;
                    header("Location: ../index.php?signup=success");
                    exit();
                }
            }
            $pdo = null;
        } catch (PDOException $e) {
            header("Location: ../index.php?error=error2");
            exit();
        }
        /*---------------------------END - SIGN UP & HASHING THE PASSWORD----------------------------*/
    }
} else {
    header("Location: ../index.php");
    exit();
}
