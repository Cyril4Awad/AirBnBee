<?php
session_start();
$message = "";

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
    
            // Check if email already exists in the database
            $emailCheckQuery = "SELECT * FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $emailCheckQuery);
    
            if (mysqli_num_rows($result) > 0) {
                // Email already exists
                echo "Email already exists in the database.";
            } else {
                // Email doesn't exist, proceed with insertion
                $hash = password_hash($password, PASSWORD_DEFAULT);
    
                $sql = "INSERT INTO user (first_name, last_name, password, email)
                    VALUES ('$firstName','$lastName', '$password', '$email') ";
    
                mysqli_query($conn, $sql);
                header("Location:../log in/login.php");
            }
        }
    }
    
mysqli_close($conn);
