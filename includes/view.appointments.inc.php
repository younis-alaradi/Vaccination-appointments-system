<table class="table table-hover table-responsive-sm text-center">
    <thead>
        <tr>
            <th scope="col">Full Name</th>
            <th scope="col">Appoinment Date</th>
            <th scope="col">Appointment Time</th>
            <th scope="col">Telephone</th>
            <th scope="col">Booking Date</th>
            <th scope="col">Comments</th>
            <th class="table-danger" scope="col"></th>
        </tr>
    </thead>
    <tbody>


        <?php

        //check if user is logged in
        if (isset($_SESSION['user_id'])) {

            require 'config.php';


            $user = $_SESSION['user_id'];
            $role = $_SESSION['role'];

            try {
                $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                /**
                 * Securing the system using prepared statement
                */
                if ($role == 2) //admin - show all appointments
                    $sql = "SELECT * FROM appointment";
                else //normal user - show this user appointments
                    $sql = "SELECT * FROM appointment WHERE user_id = ?";

                // using prepared statement to be in secure way to prevent attackers exploit any holes in the system 

                $pre = $pdo->prepare($sql);
                $pre->bindValue(1, $user);
                $pre->execute();

                // $result = $pdo->query($sql);

                if ($pre->rowCount() > 0) {
                    while ($row = $pre->fetch()) {
                        echo "
                    <tr>
                        <form action='includes/delete.php' method='POST'>
                            <input name='id' type='hidden' value=" . $row["id"] . ">
                            <input type='hidden' name='date' value=".$row["date"].">
                            <th scope='row'>" . $row["f_name"] . " " . $row["l_name"] . "</th>
                            <td>" . $row["date"] . "</td>
                            <td>" . $row["time"] . "</td>
                            <td>" . $row["telephone"] . "</td>
                            <td>" . $row["reg_date"] . "</td>
                            <td><textarea readonly>" . $row["comment"] . "</textarea></td>
                            <td class='table-danger'><button type='submit' name='delete-submit' class='btn btn-danger btn-sm'>Cancel</button></td>
                        </form>
                    </tr>
                    ";
                    }
                } else {
                    echo "<p class='text-white text-center bg-danger'>Your appointments list is empty!<p>";
                }
                $pdo = null;
            } catch (PDOException $e) {
                header("Location: ../index.php?error1=error");
                exit();
            }
        }



        ?>


    </tbody>

</table>