
<?php
include("login.html");

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


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["login"])) {
       
            $email = mysqli_real_escape_string($conn,$_POST['email']);
            $password = mysqli_real_escape_string($conn,$_POST['password']);


            $result = mysqli_query($conn,"SELECT * FROM user WHERE email='$email' AND Password='$password' ") or die("Select Error");
            $row = mysqli_fetch_assoc($result);

            if(is_array($row) && !empty($row)){
                $_SESSION['valid'] = $row['email'];
                $_SESSION['password'] = $row['password'];
    }
    else{
        echo"<script> alert('Wrong Email or Password! Please try again.') </script>";
    }
}

mysqli_close($conn);

}