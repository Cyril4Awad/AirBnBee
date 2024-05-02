<!-- Badda choghel ba3ed ma kholset 

    1.Bade ekhod mn l database l info
    2.Compare l info maa3 l user input
    3.eza msh mawjoude ello yaamol signup-->





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
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $query = "SELECT * FROM user where email='" . $email . "' and password='" . $password . "'";
    
    $result = mysqli_query($con, $query);
    $row  = mysqli_fetch_array($result);
    
    if (is_array($row)) {
        $_SESSION["userId"] = $row['user_id'];
        $_SESSION["email"] = $row['email'];
        $_SESSION["firstName"] = $row['first_name'];
    } else {
        $message = "<script>alert('Invalid Email or Password')</script>";
        echo $message;
    }
}
if (isset($_SESSION["userId"])) {
    header("Location:../home page/main.php");
}
include("login.html");
?>