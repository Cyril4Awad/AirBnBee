<?php

session_start();
$message = "";

$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "airbnbee";
$conn = "";


$conn = mysqli_connect(
    $db_server,
    $db_user,
    $db_pass,
    $db_name
);

if (count($_POST) > 0) {

    $con = $conn or die("Unable to connect");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Query to check if the user exists in the database
        $sql = "SELECT user_id, email, first_name, user_role, password FROM user WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

          
                // If user exists and password is correct, start a session
                $_SESSION["loggedin"] = true;
                $_SESSION["userId"] = $row['user_id'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["firstName"] = $row['first_name'];
                $_SESSION["userRole"] = $row['user_role'];

                // Redirect based on user role
                if ($row['user_role'] == 1) {
                    header("Location: ../home page/admin.php");
                } else {
                    header("Location: ../home page/main.php");
                }
                exit();
            } else {
                $message = "<script>alert('Invalid Email or Password')</script>";
                echo $message;
            }
        } else {
            $message = "<script>alert('Invalid Email or Password')</script>";
            echo $message;
        }
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../../styles/style.css">
    <title>AirBnBee | Login</title>
</head>

<body>

    <!----------------------- Main Container -------------------------->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <!----------------------- Login Container -------------------------->

        <div class="row border rounded-5 p-3 bg-white shadow box-area">

            <!--------------------------- Left Box ----------------------------->

            <div class="col-md-6 rounded-5 d-flex justify-content-center align-items-center flex-column left-box">
                <div class="featured-image mb-7 rounded-5 left-box">
                    <img src="../../assets/images/tinyhouse-hidden-airbnb.jpg" class="img-fluid mb-3 house_img">
                </div>
            </div>



            <!-------------------- ------ Right Box ---------------------------->

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2> <a style="text-decoration: none;" href="../Home Page/homepage.html">
                                <img src="../../assets/images/AirBnBee logo.png" class="bee_logo" />
                            </a>
                            Hello, Again
                        </h2>
                        <p>We are happy to have you back.</p>
                    </div>
                    <form action="login.php" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" name="email" placeholder="Email address" required>
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div></div>
                            <div class="forgot">
                                <small><a href="../Forget Password/forget-password.html">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6" name="login">Login</button>
                        </div>
                    </form>
                    <div class="row">
                        <small>Don't have an account? <a href="../Sign Up/sign-up.html">Sign Up</a></small>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>