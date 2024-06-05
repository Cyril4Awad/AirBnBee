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
    header("Location: ../log in/login.html");
    exit();
}

// Function to get the user's rating for a listing
function get_user_rating($ad_id)
{

    // Check if the user is logged in
    if (!isset($_SESSION['userId'])) {
        return null; // User not logged in, so no rating available
    }

    // Get the user_id from the session
    $user_id = $_SESSION['userId'];

    // Check if the listing is a favorite for the user
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

    // Check if the user has rated the listing
    $check_sql = "SELECT rating FROM rating WHERE user_id = ? AND ad_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $ad_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User has rated the listing, fetch and return their rating
        $row = $result->fetch_assoc();
        return $row['rating'];
    } else {
        // User has not rated the listing
        return null;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php

// Get the listing ID from the query parameter
$ad_id = isset($_GET['ad_id']) ? intval($_GET['ad_id']) : 1;    // Default to 1 if no ID is provided
$user_id = $_SESSION['userId'];

// Prepare the SQL statement to fetch the listing details and user details in one go
$sql = "SELECT l.*, u.first_name, u.last_name, u.email, u.phone_number 
        FROM listing l 
        INNER JOIN user u ON l.user_id = u.user_id 
        WHERE l.ad_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ad_id);
$stmt->execute();
$result = $stmt->get_result();

// Check for errors
if (!$result) {
    echo "Error: " . $conn->error;
    exit;
}

// Check if the listing exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $uploadDir = $row['upload_directory'];
    $file_paths = json_decode($row['file_path'], true); // Decode the JSON array
    $fName = $row['first_name'];
    $lName = $row['last_name'];
    $email = $row['email'];
    $phone_number = $row['phone_number'];
} else {
    echo "Listing not found!";
    exit;
}
$stmt->close();
// Query to count the number of reviews for this listing
$review_sql = "SELECT COUNT(*) as review_count FROM reviews WHERE ad_id = ?";
$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("i", $ad_id);
$review_stmt->execute();
$review_result = $review_stmt->get_result();
$review_count = 0;

if ($review_result->num_rows > 0) {
    $review_row = $review_result->fetch_assoc();
    $review_count = $review_row['review_count'];
}
$review_stmt->close();
// Calculate the average rating and count the number of reviews
$sql_rating = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM rating WHERE ad_id = ?";
$stmt_rating = $conn->prepare($sql_rating);
$stmt_rating->bind_param("i", $ad_id);
$stmt_rating->execute();
$result_rating = $stmt_rating->get_result();

if ($result_rating->num_rows > 0) {
    $rating_row = $result_rating->fetch_assoc();
    $avg_rating = number_format($rating_row['avg_rating'], 2); // Format to 2 decimal places
    $rating_count = $rating_row['review_count'];
} else {
    $avg_rating = "No ratings yet";
    $rating_count = 0;
}

$sql_guests = "SELECT num_guests FROM listing WHERE ad_id=?";
$stmt_guests = $conn->prepare($sql_guests);
$stmt_guests->bind_param("i", $ad_id);
$stmt_guests->execute();
$stmt_guests->bind_result($maxGuests);
$stmt_guests->fetch();
$stmt_guests->close();

$today = date("d-m-Y");
$tomorrow = date("d-m-Y", strtotime("+1 day"));

$reservations = [];
$sql_validateDates = "SELECT check_in, check_out FROM rent WHERE ad_id=?";
$stmt = $conn->prepare($sql_validateDates);
if ($stmt) {
    $stmt->bind_param("i", $ad_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row_validationDates = $result->fetch_assoc()) {
        $reservations[] = $row_validationDates;
    }
    $stmt->close();
} else {
    die("Error preparing statement: " . $conn->error);
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing - Airbnbee</title>

    <!-- CSS file -->
    <link rel="stylesheet" href="ListingStyle.css" />

    <!-- Bootstrap style -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- BootStrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Boot Strap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Bootstrap imgages-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <script>
        function validateDates() {
            const checkIn = new Date(document.getElementById('check-in').value);
            const checkOut = new Date(document.getElementById('check-out').value);
            const reservations = <?php echo json_encode($reservations); ?>;
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to midnight for comparison

            // Check if the selected dates are in the past
            if (checkIn < today || checkOut < today) {
                alert("You cannot select dates that are in the past.");
                return false;
            }

            // Check if the check-out date is before the check-in date
            if (checkOut <= checkIn) {
                alert("The check-out date cannot be earlier than or the same as the check-in date.");
                return false;
            }

            // Check if the selected dates overlap with any existing reservations
            for (let i = 0; i < reservations.length; i++) {
                const reservedCheckIn = new Date(reservations[i].check_in);
                const reservedCheckOut = new Date(reservations[i].check_out);

                if ((checkIn >= reservedCheckIn && checkIn <= reservedCheckOut) ||
                    (checkOut >= reservedCheckIn && checkOut <= reservedCheckOut) ||
                    (checkIn <= reservedCheckIn && checkOut >= reservedCheckOut)) {
                    alert("The selected dates overlap with an existing reservation.");
                    return false;
                }
            }

            return true;
        }


        // Price per night for the listing
        const pricePerNight = <?php echo $row['rent_price']; ?>;

        document.addEventListener('DOMContentLoaded', (event) => {
            const checkInInput = document.getElementById('check-in');
            const checkOutInput = document.getElementById('check-out');
            const totalPriceElement = document.getElementById('total-price');

            function calculateTotalPrice() {
                const checkInDate = new Date(checkInInput.value);
                const checkOutDate = new Date(checkOutInput.value);
                if (checkInDate && checkOutDate && checkOutDate > checkInDate) {
                    const timeDifference = checkOutDate - checkInDate;
                    const daysDifference = timeDifference / (1000 * 3600 * 24);
                    const totalPrice = daysDifference * pricePerNight;
                    totalPriceElement.textContent = totalPrice.toFixed(2);
                } else {
                    totalPriceElement.textContent = '0';
                }
            }

            checkInInput.addEventListener('change', calculateTotalPrice);
            checkOutInput.addEventListener('change', calculateTotalPrice);

            // Calculate the initial total price based on the default values
            calculateTotalPrice();
        });
    </script>

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
                        <a class="nav-link active" href="#">Booking</a>
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
                                                                                                                                                                                                                                echo 'width: 50px; height: 50px; margin-right: 70px; border-radius: 50%; border: 1px solid black;';
                                                                                                                                                                                                                            } ?>">
                                    <?php if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    } ?>
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="../Profile/profile.php">My profile</a>
                                    <a class="dropdown-item" href="../favorites/favorites.php">Favorites</a>
                                    <a class="dropdown-item" href="../Manage Listings/manage.php">Manage Listings</a>
                                    <a class="dropdown-item" href="../log out/logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </nav>

    <div class="row no-gutters img">
        <div class="tile col-lg-6">
            <a href="<?php echo $uploadDir . $file_paths[0]; ?>">
                <img src="<?php echo $uploadDir . $file_paths[0]; ?>" class="img-fluid img-style" alt="Responsive image" style="opacity: 1;">
            </a>
        </div>
        <div class="tile col-lg-6">
            <div class="row no-gutters">
                <?php for ($i = 1; $i <= 4; $i++) : ?>
                    <?php if (isset($file_paths[$i])) : ?>
                        <div class="tile col-lg-6">
                            <img src="<?php echo $uploadDir . $file_paths[$i]; ?>" class="img-fluid img-style<?php if ($i % 2 != 0) {
                                                                                                                    echo '2';
                                                                                                                } elseif ($i == 2) {
                                                                                                                    echo '1';
                                                                                                                } elseif ($i == 4) {
                                                                                                                    echo '3';
                                                                                                                } ?>" alt="Responsive image" style="opacity: 1;">

                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>



        <div class="left-container">
            <div>
                <h1><?php echo $row['ad_title']; ?></h1>

                <div class="star">
                    &#9733; <?php echo $avg_rating; ?>
                    <a href="../Reviews/reviews.php?ad_id=<?php echo urlencode($ad_id); ?>">
                        <?php echo $review_count; ?> Reviews
                    </a>
                </div>

                <h2>Rate this listing</h2>
                <?php
                // Get the user's rating for the current listing
                $user_rating = get_user_rating($row['ad_id']);
                ?>
                <form id="ratingForm" method="post" action="../rating/rating.php">
                    <div class="rating-container mt-2">
                        <div class="rating">
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <span data-value="<?php echo $i; ?>" class="star<?php echo ($user_rating != null && $i <= $user_rating) ? ' active' : ''; ?>" disabled>&#x2605;</span>
                            <?php } ?>
                        </div>
                        <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <div class="submit-container ml-4">
                            <button class="btn btn-primary mt-2" id="submitRating" <?php echo ($user_rating != null) ? 'disabled' : ''; ?>>Submit</button>
                        </div>
                    </div>
                </form>






                <!-- Description section -->
                <div class="section-title">Description:</div>
                <div class="section-content">
                    <p><?php echo $row['description']; ?></p>
                </div>
                <!-- Price section -->
                <div class="section-title">Price:</div>
                <div class="section-content">
                    <p><?php echo $row['rent_price']; ?> per night</p>
                </div>
                <!-- Location section -->
                <div class="section-title">Location:</div>
                <div class="section-content">
                    <p>Country: <?php echo $row['country']; ?></p>
                    <p>City: <?php echo $row['city']; ?></p>
                    <p>Street Number: <?php echo $row['street_number']; ?></p>
                </div>
                <!-- Contact Host section -->
                <div class="section-title">Contact Host:</div>
                <div class="section-content">
                    <p>Name: <?php echo $fName . ' ' . $lName; ?></p>
                    <p>Email: <?php echo $email; ?></p>
                    <p>Phone: <?php echo $phone_number; ?></p>
                </div>
            </div>

            <div class="sticky-container">
                <h1>$ / Night</h1>
                <form class="reservation-form" action="booking.php" method="post" onsubmit="return validateDates()">
                    <div><b>
                            <div class="checkin">
                                <label for="check-in">CHECK-IN</label><br>
                                <input type="date" id="check-in" name="check-in" value=" <?php echo $today ?>">
                            </div>
                            <div class="checkout">
                                <label for="check-out">CHECKOUT</label><br>
                                <input type="date" id="check-out" name="check-out" value="<?php echo $tomorrow ?>">
                            </div>
                    </div>
                    <div class="guest">
                        <label for="guest">GUESTS</label>
                        <select style="width: 90%;border: 0;" id="guest" name="guest">
                            <?php
                            for ($i = 1; $i <= $maxGuests; $i++) {
                                echo "<option value='$i'>{$i} guest" . ($i > 1 ? 's' : '') . "</option>";
                            }
                            ?>
                        </select>
                        </b>
                    </div>
                    <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
                    <button class="button" type="submit"><b>Reserve</b></button>
                    <div class="prices">
                        <p>Total Price: <span id="total-price">0</span> $</p>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        // Check if there is a rating stored in the session
        var storedRating = <?php echo isset($_SESSION['rating']) ? $_SESSION['rating'] : 'null'; ?>;

        // If there is a stored rating, mark the corresponding stars as selected
        if (storedRating !== null) {
            $('.star').each(function(index) {
                if (index < storedRating) {
                    $(this).addClass('selected');
                }
            });
        }

        // Function to handle star selection
        $('.star').click(function() {
            // Remove 'selected' class from all stars
            $('.star').removeClass('selected');
            // Add 'selected' class to clicked star and previous stars
            $(this).addClass('selected');
            $(this).prevAll().addClass('selected');

            // Update the stored rating in the session
            var rating = $(this).index() + 1;
            <?php $_SESSION['rating'] = "' + rating + '"; ?>;
        });

        // Function to handle form submission
        $('#ratingForm').submit(function(event) {
            event.preventDefault(); // Prevent form submission

            // Count the number of selected stars
            var rating = $('.star.selected').length;

            // Add the rating value to a hidden input field in the form
            $('<input>').attr({
                type: 'hidden',
                name: 'rating',
                value: rating
            }).appendTo('#ratingForm');

            // Update the stored rating in the session
            <?php $_SESSION['rating'] = "' + rating + '"; ?>;

            // Submit the form
            this.submit();
        });
    });
</script>

</html>