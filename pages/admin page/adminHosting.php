<?php
// Check if user_id is set in the URL
$user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($user_id) {
    // Use the user_id for creating a new listing
    // For example, you can pass it to the hosting form or directly create a new listing
    // Redirect to the hosting page with the user_id
    header("Location: ../create listing/hosting.php?user_id=" . urlencode($user_id));
    exit();
} else {
    echo "User ID not provided.";
}
?>
