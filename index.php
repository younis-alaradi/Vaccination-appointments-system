<?php
require "header.php";
/**
 * Author : Hadeel Abdulmajed Hamza 
 * Purpose : Consume web services using REST API 
 * Method : using file get content function & json_decode 
 */

function execute_json_using_FileGetContent()
{
    $url = "https://disease.sh/v3/covid-19/vaccine/coverage/countries/Bahrain";
    $response = file_get_contents($url); // getting the data 
    $Vaccination_statics =  json_decode($response); // parsing the json data 
    if (json_last_error() == JSON_ERROR_NONE) { // validate the data 

        echo "<h1>" . $Vaccination_statics->country . " </h1>"; // printing the name because it is a key with value 

        /*Using foreach loop , because the second key  of the parent array 
        is a time line , but the value of it , it is an associaitve array that hold the dates 
        and the statics  */
        $index = 0;
        foreach ($Vaccination_statics->timeline as $Date => $statics_Per_Day) {

            echo ' 
            <div class="accordion-item" >
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $index . '" aria-expanded="false" aria-controls="collapseTwo">
               <strong>Date</strong> : ' . $Date . '
              </button>
            </h2>
            <div id="collapse-' . $index . '" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
               Number of vaccinated peoples :  ' . $statics_Per_Day . '
              </div>
            </div>
          </div><br>';
            $index++;
        }
    }
}
function execute_vaccines_Info()
{
    #This for vaccination info 
    $request = "https://disease.sh/v3/covid-19/vaccine";
    $response = file_get_contents($request);
    $data = json_decode($response);

    $index = 1;
    foreach ($data->data as $innerArray) {
        echo
        '<div class="container" id="vaccinesInfo">
        <div class="accordion-item">
        <h2 class="accordion-header">
        <!-- Item header -->                  
         <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-' . $index . '" aria-expanded="false" aria-controls="flush-collapseOne">

        <span class="badge bg-primary">' . $index . '</span>  &nbsp;     ' . $innerArray->candidate . ' ,  ';
        foreach ($innerArray->sponsors as $sponsors) {
            echo  $sponsors . " , ";
            if (empty($sponsors))
                echo ".";
        }
        echo '
     </button>
     </h2>
     <!-- END -  Item header -->    

     <div id="flush-' . $index . '" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

     <div class="accordion-body">

     <!-- Inner data  - item body r -->    
     <div class="card-header">
     <strong>Candidate Name : </strong> :  ' . $innerArray->candidate . '
     </div>

     <div class="card-header">
     <strong>Mechanism</strong> :  ' . $innerArray->mechanism . '
     </div>

     <div class="card-header">
     <strong>Sponsors</strong> :';
        foreach ($innerArray->sponsors as $sponsors) {
            echo  $sponsors . " , ";
            if (empty($sponsors))
                echo ".";
        }
        echo '</div>
    <div class="card-header">
    <strong>Instituations :</strong>    ';
        foreach ($innerArray->institutions as $ins) {
            if (empty($ins)) {
                echo " nothing";
            } else
                echo "" . $ins;
        }
        echo ' 
    </div>

        <div class="card-body">
        <strong>Background Information </strong>
       <p>' . $innerArray->details . '</p>

    </div>
    </div>
    </div>
    <!-- END  Inner data  - item body r -->    

    </div>
    </div>
    </div>';
        $index++;
    }
} // execute vaccines information using REST API 
?>

<!-- site main banner with logo -->
<header class="header">
    <div class="row">
        <div class="col-md-12 text-center">
            <a class="logo"><img src="img/logo.png" alt="logo"></a>
        </div>
        <div class="col-md-12 text-center">
            <button type="button" onclick="window.location.href='appointment.php'" class="btn btn-outline-light btn-lg"><em>Make an Appoinment Now!</em></button>
        </div>
    </div>
</header>



<!--about us section-->
<section id="aboutus">
    <div class="container" id="About-Container">
        <h3 class="text-center"><br><br>Vaccination Appointment System</h3>
        <div class="row">
            <!--carousel-->
            <div class="col-sm"><br><br>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="img/3.jpeg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/4.jpeg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="img/5.jpeg" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div><br><br>
            </div>
            <!--end of carousel-->


            <div class="col-sm">
                <div class="arranging"><br>
                    <hr>
                    <h4 class="text-center">WHO - COVID Vaccines</h4>
                    <p><br>Equitable access to safe and effective vaccines is critical to ending the COVID-19 pandemic, so it is hugely encouraging to see so many vaccines proving and going into development. WHO is working tirelessly with partners to develop, manufacture and deploy safe and effective vaccines.<br>
                        Safe and effective vaccines are a game-changing tool: but for the foreseeable future we must continue wearing masks, cleaning our hands, ensuring good ventilation indoors, physically distancing and avoiding crowds. Being vaccinated does not mean that we can throw caution to the wind and put ourselves and others at risk, particularly because research is still ongoing into how much vaccines protect not only against disease but also against infection and transmission.
                        <br><br><br>
                    </p>
                    <hr>
                    <button class="btn btn-outline-dark btn-block btn-lg" id="vacc-statics-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Vaccination Statics</button>

                </div><br>
            </div>

        </div>
    </div>
</section><br>
<!--end of about us section-->
<div class="header2">
</div>

<!-- vaccination statics & information -->

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel"><strong>Vaccination Statics</strong></h5>
        <button type="button" class="btn-close text-reset" id="close-offCanvas" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="offCanvas-body">
        <!-- Data here-->
        <div class=" accordion accordion-flush" id="accordionExample">
        </div>
        <?php
        // using function to get the information 
        Execute_json_using_FileGetContent();
        ?>

        <!--  end - Data here-->
    </div>
</div><br><br>

<!-- vaccination information using REST API -->
<div class="container" id="vaccinesInfo">
    <h3 class="text-center"><br><br>Vaccines Information's</h3>
    <hr>
    <?php Execute_vaccines_Info() ?>
</div>
<br><br>
<!-- vaccination information using REST API -->

<div class="header2">
</div>


<!-- END - vaccination statics & information -->



<!----gallery -->
<div class id="gallery"><br>
    <div class="container" id="galleryContainer">
        <h3 class="text-center" id="gallery-title"><br>Gallery<br><br></h3>
        <div class="d-flex flex-row flex-wrap justify-content-center" id="firstTwoGallery">
            <div class="d-flex flex-column">
                <img src="img/1.jpg" class="img-fluid">
                <img src="img/2.png" class="img-fluid">
            </div>
            <div class="d-flex flex-column">
                <img src="img/3.jpeg" class="img-fluid">
                <img src="img/4.jpeg" class="img-fluid">
            </div>
            <div class="d-flex flex-column">
                <img src="img/5.jpeg" class="img-fluid">
                <img src="img/6.jpeg" class="img-fluid">
            </div>
            <div class="d-flex flex-column">
                <img src="img/7.jpeg" class="img-fluid">
                <img src="img/8.jpeg" class="img-fluid">
            </div>
        </div>
    </div>
</div><br><br>
<!----end of gallery -->

<div class="container" id="appointment">
    <h3 class="text-center"><br><br>Appointment<br><br></h3>
    <img src="img/16.jpg" class="img-fluid rounded">
    <button type="button" onclick="window.location.href='appointment.php'" class="btn btn-outline-dark btn-block btn-lg" id="makeAppoinBTN">Make an appointment Now!</button>

</div><br><br><br><br>

<div class="header2">
</div>

<!-- main page map section-->
<section class="map" id="footer">
    <div class="container" id="mapContainer">
        <h3 class="text-center"><br><br>Find us!</h3><br>
        <iframe src="https://www.google.com/maps/d/embed?mid=19wJl5eLw943zm9VQn74gTvVMFJI" style="width:100%;  height:250px; border:0;" allowfullscreen></iframe>

        <div class="row staff">
            <div class="col">
                <h4><strong>Vaccination Schedule</strong></h4>

                <div class="signup-form">
                    <form action="#footer" method="post">
                        <div class="form-group">
                            <label>Enter Date</label>
                            <input type="date" class="form-control" name="date" placeholder="Date" required="required">
                        </div>
                        <div class="form-group">
                            <button type="submit" name="check_schedule" class="btn btn-dark btn-block" id="checkSheduleMap">Check Schedule</button>
                        </div>
                    </form>

                    <?php

                    if (isset($_POST['check_schedule'])) {

                        require 'includes/config.php';

                        $date = $_POST['date'];

                        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // using prepared statement to prevent any injections might occur 
                        $sql = "SELECT * FROM schedule WHERE date =?";
                        // $result = $pdo->query($sql);
                        $pre = $pdo->prepare($sql);
                        $pre->bindValue(1, $date);
                        $pre->execute();

                        echo "
            <table class='table table-sm table-striped table-dark text-center'>
            <thead>
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
                        <th scope='row'><em>" . $date . "</em></th>
                        <td>" . $row['open_time'] . "</td>
                        <td>" . $row['close_time'] . "</td>
                        <td>" . $row['appointments'] . "</td>
                    </tr>";
                            }
                        } else { //when no schedule found for the selected date
                            echo "                   
                <tr>
                    <th scope='row'><em>" . $date . "</em></th>
                    <td>not available</td>
                    <td></td>
                    <td></td>
                </tr>";
                        }
                        echo "        
            </tbody>
            </table>";

                        //close connection
                        $pdo = null;
                    }
                    ?>

                </div><br>
            </div>

            <div class="col">

                <p class="text-right">Vaccination Appointment System<br><i class="fa fa-map-marker"></i><br><br>email: info@vas.com<br>phone: 444</p>
            </div>

        </div>
    </div>
</section>
<!--end of main page map section-->


<?php
require "footer.php";
?>