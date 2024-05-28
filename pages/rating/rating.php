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


$user_id = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = $_POST['ad_id'];
    $rating = $_POST['rating'];

    $insert_sql = "INSERT INTO rating (ad_id, user_id, rating) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iii", $ad_id, $user_id, $rating);
    
    if ($insert_stmt->execute()) {
        echo 'Rating added successfully';
        header("location: ../listing page/listing.php?ad_id=$ad_id");
    } else {
        echo 'Error adding rating: ' . $insert_stmt->error;
    }
} else {
    echo 'Invalid request method';
}
?>
