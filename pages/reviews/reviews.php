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

// Fetch reviews from the database
$ad_id = isset($_GET['ad_id']) ? intval($_GET['ad_id']) : 0;

$sql = "
    SELECT u.first_name, u.last_name, r.created_at, r.review 
    FROM reviews r
    JOIN user u ON r.user_id = u.user_id
    WHERE r.ad_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ad_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle form submission to add a new review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['userId']; // Assuming you have user_id stored in session
    $review_text = $_POST['review_text'];
    $ad_id = $_POST['ad_id'];

    $insert_sql = "INSERT INTO reviews (user_id, ad_id, review) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iis", $user_id, $ad_id, $review_text);
    if ($insert_stmt->execute()) {
        // Redirect to the same page to show the new review
        header("Location: reviews.php?ad_id=$ad_id");
        exit();
    } else {
        echo "Error: " . $insert_stmt->error;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- CSS File -->
    <style>
        .logo_img {
            width: 90px;
            height: 64px;
            margin-right: -30px;
            margin-left: 0px;
        }

        .review {
            background-color: #f8f9fa;
            height: 250px;
            /* Fixed height for consistency */
            overflow-y: auto;
            /* Scroll option for overflow text */
        }

        .review .reviewer {
            font-size: 1.1em;
            margin-bottom: 0.2em;
        }

        .review .date {
            font-size: 0.9em;
        }

        .review .rating {
            font-size: 1.2em;
        }

        .review-text p {
            margin: 0.5em 0;
        }

        button {
            padding: 0.6em 1.2em;
            font-size: 1.1em;
        }
    </style>
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
                        <a class="nav-link" href="../home page/main.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../listing page/listing.php?ad_id=<?php echo $ad_id ?>">Back to Listing</a>
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
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" 
                                role="button" data-toggle="dropdown" aria-haspopup="true" 
                                aria-expanded="false" style="<?php if (isset($_SESSION['firstName'])) {
                                        echo 'width: 50px; height: 50px; margin-right: 90px; border-radius: 50%; border: 1px solid black;';
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
    <div class="container mt-5">
        <h2 class="text-center mb-4">Customer Reviews</h2>
        <div class="row mb-4">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="col-md-6">
                    <div class="review p-3 mb-3 border rounded">
                        <p class="reviewer font-weight-bold"><?= htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) ?></p>
                        <p class="date text-muted"><?= htmlspecialchars($row['created_at']) ?></p>
                        <div class="review-text">
                            <p><?= htmlspecialchars($row['review']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="text-center mb-4">
            <button class="btn btn-primary" data-toggle="modal" data-target="#reviewModal">Add Your Review</button>
        </div>
    </div>

    <!-- Modal for adding reviews -->
    <div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Add Your Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" method="post" action="reviews.php">

                        <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
                        <div class="form-group">
                            <label for="review_text">Review</label>
                            <textarea class="form-control" id="review_text" name="review_text" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add My Review</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>