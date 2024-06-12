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
    header("Location: ../log in/login.php");
    exit();
}

$user_id = $_SESSION['userId'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = $_POST['ad_id'];
    $rating = $_POST['rating'];

    // Check if the rating is already stored in session
    if (isset($_SESSION['rated_' . $ad_id])) {
        echo 'You have already rated this listing.';
        header("Location: ../listing page/listing.php?ad_id=$ad_id");
        exit();
    }

    // Check if the user has already rated this listing in the database
    $check_sql = "SELECT * FROM rating WHERE ad_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $ad_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['rated_' . $ad_id] = true;
        echo 'You have already rated this listing.';
        header("Location: ../listing page/listing.php?ad_id=$ad_id");
    } else {
        $insert_sql = "INSERT INTO rating (ad_id, user_id, rating) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $ad_id, $user_id, $rating);

        if ($insert_stmt->execute()) {
            $_SESSION['rated_' . $ad_id] = true;
            echo 'Rating added successfully';
            header("Location: ../listing page/listing.php?ad_id=$ad_id");
        } else {
            echo 'Error adding rating: ' . $insert_stmt->error;
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $ad_id = $_POST['ad_id'];

    // Delete the rating from the database
    $delete_sql = "DELETE FROM rating WHERE ad_id = ? AND user_id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("ii", $ad_id, $user_id);

    if ($delete_stmt->execute()) {
        // Unset the session variable
        unset($_SESSION['rated_' . $ad_id]);
        echo 'Rating deleted successfully';
        header("Location: ../listing page/listing.php?ad_id=$ad_id");
    } else {
        echo 'Error deleting rating: ' . $delete_stmt->error;
    }
} else {
    echo 'Invalid request method';
}

$conn->close();
?>
