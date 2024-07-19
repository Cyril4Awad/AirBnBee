<?php
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
if (!isset($_SESSION['userId'])) {
    return null; // User not logged in, so no rating available
}

$userid = $_SESSION['userId'];

// Cancel booking if requested
if (isset($_POST['cancel'])) {
    $bookingId = $_POST['booking_id'];
    $cancelQuery = "DELETE FROM rent WHERE rent_id = ?";
    $stmt = $conn->prepare($cancelQuery);
    $stmt->bind_param("i", $bookingId);
    if ($stmt->execute()) {
        echo "<script> alert('Booking cancelled successfully.') </script>";
    } else {
        echo "<script> alert('Error cancelling booking')</script>" . $conn->error;
    }
    $stmt->close();
}

// Select all bookings for the logged-in user
$query = "SELECT r.rent_id, l.ad_title AS item, r.check_in, r.check_out 
          FROM rent r
          JOIN listing l ON r.ad_id = l.ad_id
          WHERE r.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boot Strap CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Boot Strap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
     <!-- CSS file -->
     <link rel="stylesheet" href="../home page/style.css" />
     <style>
        
            table {
                border-collapse: collapse;
                width: 90%;
                margin-left: 30px;
                margin-bottom: 50px;
            }
            th, td {
                border: 2px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
          </style>

    <title>Manage Your bookings</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../../assets/images/AirBnBee logo.png" alt="Your Logo" class="logo_img">
                Airbnbee
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_SESSION['userRole'] == 1 ? '../Home Page/admin.php' : '../Home Page/main.php'; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Manage Your bookings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Create Listing/hosting.php">Host Your Ad</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../about us page/aboutus.php">About Us</a>
                    </li>
                </ul>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="<?php if (isset($_SESSION['firstName'])) {
                                                                                                                                                                                                                                echo 'width: 50px; height: 50px; margin-right: 50px; border-radius: 50%; border: 1px solid black;';
                                                                                                                                                                                                                            } ?>">
                                    <?php if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    } ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="../Profile/profile.php">My profile</a>
                                    <a class="dropdown-item" href="../Manage Listings/manage.php">Manage Listings</a>
                                    <a class="dropdown-item" href="../favorites/favorites.php">Favorites</a>
                                    <a class="dropdown-item" href="../log out/logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </nav>


    <h2 style="  text-align: center;padding: 20px;margin: 20px;">Bookings</h2>
    <?php
    if ($result->num_rows > 0) {
        echo "<table border='2'>
                <tr>
                    <th>Booking ID</th>
                    <th>Property</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['rent_id']}</td>
                    <td>{$row['item']}</td>
                    <td>{$row['check_in']}</td>
                    <td>{$row['check_out']}</td>
                    <td>
                        <form method='post' action=''>
                            <input type='hidden' name='booking_id' value='{$row['rent_id']}'>
                            <input type='submit' name='cancel' value='Cancel Booking'>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<h5>No bookings found.</h5>";
    }
    ?>
    <!-- Footer -->
    <footer class="bg-light text-black py-4">
        <div class="container text-center">
            <p>&copy; 2024 Airbnbee. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
<?php
$stmt->close();
$conn->close();
?>