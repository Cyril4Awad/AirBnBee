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
    <title>About Us - Airbnbee</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="aboutus.css" />
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../assets/images/AirBnBee logo.png" alt="Your Logo" class="logo_img">
                Airbnbee
            </a>
            <!-- <a class="navbar-brand" href="#">Airbnbbee</a> -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php if (isset($_SESSION['userId']) && ($_SESSION['userRole'] == 1)) {
                                                        echo '../Home Page/admin.php';
                                                    } else if (isset($_SESSION['userId']) && ($_SESSION['userRole'] == 0)) {
                                                        echo '../Home Page/main.php';
                                                    } else {
                                                        echo '../home page/startpage.php';
                                                    }
                                                    ?>">Home</a>

                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Us Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h2 class="display-4">Welcome to Airbnbee</h2>
                    <p class="lead">Experience the joy of travel like never before with Airbnbbee. We're not just another vacation rental platform; we're a community-driven marketplace connecting travelers with unique stays and unforgettable experiences around the world.</p>
                    <p>Whether you're looking for a cozy cottage in the countryside, a chic urban apartment, or an adventurous treehouse in the forest, Airbnbbee has got you covered. With our vast selection of accommodations and personalized recommendations, you can find the perfect place to stay, no matter your destination or budget.</p>
                </div>
                <div class="col-lg-6">
                    <!-- Image showcasing the diversity of accommodations -->
                    <img src="../../assets/images/Aboutus.webp" class="img-fluid rounded" alt="Diverse Accommodations">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-light py-5">
        <div class="container">
            <h2 class="text-center">Why Choose Airbnbee?</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Unique Stays</h5>
                            <p class="card-text">Discover one-of-a-kind accommodations that reflect the culture and spirit of your destination.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Local Experiences</h5>
                            <p class="card-text">Immerse yourself in the local culture with guided tours, cooking classes, and other authentic experiences.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Secure Booking</h5>
                            <p class="card-text">Book with confidence knowing that your payments are secure, and our support team is available 24/7 to assist you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light text-black py-4">
        <div class="container text-center">
            <p>&copy; 2024 Airbnbee. All rights reserved.</p>
        </div>
    </footer>


</body>

</html>