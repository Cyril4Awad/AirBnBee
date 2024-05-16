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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS file -->
    <link rel="stylesheet" href="../Home Page/style.css" />
    <!-- Boot Strap CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- Boot Strap script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- Java Script file -->
    <script src="../Home Page/homepage.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title> Manage Listings </title>
    <style>
        /* Set fixed dimensions for carousel images */
        .carousel-item img {
            width: 100%;
            height: 300px;
            /* Adjust height as needed */
            object-fit: cover;
            /* Maintain aspect ratio */
        }
    </style>
</head>

<body>
    <!-- Navigation bar -->
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
                        <a class="nav-link active" href="#">Manage Your Listings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../Create Listing/hosting.php">Host Your Ad</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../about us page/aboutus.html">About Us</a>
                    </li>
                </ul>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <!-- Avatar -->
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="<?php
                                                                                                                                                                                                                            // Apply inline styles based on the condition
                                                                                                                                                                                                                            if (isset($_SESSION['firstName'])) {
                                                                                                                                                                                                                                echo 'width: 50px; height: 50px; margin-right: 50px; border-radius: 50%; border: 1px solid black;';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            ?>">
                                    <?php
                                    // Display the first letter of the user's first name
                                    if (isset($_SESSION['firstName'])) {
                                        echo strtoupper(substr($_SESSION['firstName'], 0, 1));
                                    }
                                    ?>
                                </a>



                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">My profile</a>
                                    <a class="dropdown-item" href="../favorites/favorites.php">Favorites</a>
                                    <a class="dropdown-item" href="../log out/logout.php">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>

    </nav>


    <!-- Main content -->
    <div class="container">
        <section id="manage-listings">
            <div class="container-fluid">
                <h2 style="text-align: center;">Manage Your Listings</h2>
                <div class="row">
                    <?php
                    $carouselID = 1;

                    // Check if user is logged in
                    if (!isset($_SESSION['userId'])) {
                        // Redirect user to login page or handle the situation accordingly
                        header("Location: login.php");
                        exit();
                    }

                    // Retrieve user ID from session
                    $userId = $_SESSION['userId'];

                    // Query to fetch user's listings based on user_id
                    $sql = "SELECT * FROM listing WHERE user_id = $userId";

                    // Execute the query
                    $result = mysqli_query($conn, $sql);

                    // Check if query was successful
                    if (!$result) {
                        echo "Error: " . mysqli_error($conn);
                        exit();
                    }

                    // Fetch and display each listing separately
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Fetch image paths associated with the listing
                        $listingId = $row['ad_id'];
                        $imageQuery = "SELECT file_path FROM listing WHERE ad_id = $listingId LIMIT 5";
                        $imageResult = mysqli_query($conn, $imageQuery);
                    ?>
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div id="Listing<?php echo $carouselID; ?>Carousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php
                                            $activeClass = 'active'; // Set the active class for the first image
                                            while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                                        ?>
                                                <div class="carousel-item <?php echo $activeClass; ?>">
                                                    <img src="<?php echo $imageRow['file_path']; ?>" class="d-block w-100" alt="Listing Image">
                                                </div>
                                            <?php
                                                $activeClass = ''; // Remove active class for subsequent images
                                            }
                                       ?>
                                       
                                    </div>
                                    <!-- Carousel controls -->
                                    <a class="carousel-control-prev" href="#Listing<?php echo $carouselID; ?>Carousel" role="button" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#Listing<?php echo $carouselID; ?>Carousel" role="button" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['ad_title']; ?></h5>
                                    <p class="card-text">Price: $<?php echo $row['rent_price']; ?>/night</p>
                                    <form action="delete_listing.php" method="post">
                                        <input type="hidden" name="listing_id" value="<?php echo $row['ad_id']; ?>">
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this listing?');">Delete Listing</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php
                        $carouselID++;
                    }
                    ?>
                </div>
            </div>
        </section>
    </div>
</body>
</html>