<?php
// Start or resume a session
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airbnbee";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    // Redirect or handle unauthorized access
    header("Location: login.php"); // Redirect to login page or another appropriate page
    exit();
}

// Get the user_id from the session
$user_id = $_SESSION['userId'];

// Check if the ad_id is set in the POST request
if (isset($_POST['ad_id'])) {
    // Get the ad_id from the POST request
    $ad_id = $_POST['ad_id'];

    // Check if this listing is already a favorite
    $check_sql = "SELECT * FROM favorites WHERE user_id = ? AND ad_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $ad_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Listing is already a favorite, remove it
        $delete_sql = "DELETE FROM favorites WHERE user_id = ? AND ad_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $user_id, $ad_id);
        $delete_stmt->execute();
        $delete_stmt->close();
        echo "<script>alert('Removed from your favorites successfully!'); window.location.href='../favorites/favorites.php';</script>";
    } else {
        // Listing is not a favorite, add it
        $insert_sql = "INSERT INTO favorites (user_id, ad_id) VALUES (?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ii", $user_id, $ad_id);
        $insert_stmt->execute();
        $insert_stmt->close();
        echo "<script>alert('Added to your favorites successfully!'); window.location.href='main.php';</script>";
    }


    $stmt->close();
    mysqli_close($conn);

} else {
    echo "Error: ad_id not provided!";
}
?>
