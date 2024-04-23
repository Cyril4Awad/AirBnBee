
<!-- Badda choghel ba3ed ma kholset 

    1.Bade ekhod mn l database l info
    2.Compare l info maa3 l user input
    3.eza msh mawjoude ello yaamol signup-->





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

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (email, password)
            VALUES ('$email', '$hash') ";

        mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);

