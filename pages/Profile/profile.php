<?php
session_start();

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "airbnbee";
$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['userId'])) {
    // Redirect user to login page or handle the situation accordingly
    header("Location: ../log in/login.php");
    exit();
}
$userId = $_SESSION['userId'];
   
// SQL query to fetch user's name
$sql_user = "SELECT * FROM user WHERE user_id = $userId";
$result_user = $conn->query($sql_user);
if ($result_user->num_rows > 0) {
    // Output data of each row
    while($row = $result_user->fetch_assoc()) {
        $fName =  $row["first_name"];
        $lName = $row["last_name"];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $country = $row['country'];
        $reg_date = $row['registration_date'];
    }
} else {
    echo "0 results";
}

// SQL query to count user's listings
$sql_listing_count = "SELECT COUNT(*) AS listing_count FROM listing WHERE user_id = $userId";
$result_listing_count = $conn->query($sql_listing_count);
$row_listing_count = $result_listing_count->fetch_assoc();
$listing_count = $row_listing_count['listing_count'];

   
?>

<!DOCTYPE html>
<html>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    
    <link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css"/>
    <link rel="stylesheet" href="profile.css" />
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title mb-4">
                            <div class="d-flex justify-content-start">
                        
                                <div class="userData ml-3">
                                    <h2 class="d-block" style="font-size: 1.5rem; font-weight: bold"><a href="javascrip:tvoid(0);">
                                        <?php
                                            echo $fName . " " . $lName ;
                                        ?>
                                    </a></h2>
                                    <h6 class="d-block"><?php echo $listing_count; ?> listings</h6>
                                </div>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="basicInfo-tab" data-toggle="tab" href="#basicInfo" role="tab" aria-controls="basicInfo" aria-selected="true">Basic Info</a>
                                    </li>
                                </ul>
                                <div class="tab-content ml-1" id="myTabContent">
                                    <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
                                        

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">First Name</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?php
                                                echo $fName;
                                        ?>
                                            </div>
                                        </div>
                                        <hr />

                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Last Name</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?php 
                                                echo $lName;
                                                ?>
                                            </div>
                                        </div>
                                        <hr />
                                        
                                        
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Email</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?php
                                                echo $email;
                                            ?>
                                                </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Phone Number</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                <?php
                                                echo $phone_number;
                                            ?>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Country</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                 <?php
                                                 echo $country;
                                             ?>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3 col-md-2 col-5">
                                                <label style="font-weight:bold;">Registration Date</label>
                                            </div>
                                            <div class="col-md-8 col-6">
                                                 <?php
                                                 echo $reg_date;
                                             ?>
                                            </div>
                                        </div>

                                    </div>
                                    
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
                                    <?php $conn->close();?>