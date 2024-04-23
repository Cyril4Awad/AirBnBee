<?php

include("sign-up.html");
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

    if (isset($_POST["signup"])) {

        $firstName = filter_input(INPUT_POST, "fname", FILTER_SANITIZE_SPECIAL_CHARS);
        $lastName = filter_input(INPUT_POST, "lname", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (first_name, last_name, password, email)
            VALUES ('$firstName','$lastName', '$hash', '$email') ";

        mysqli_query($conn, $sql);
    }
}

mysqli_close($conn);
