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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['addUser'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phoneNumber'];
        $country = $_POST['country'];

        // Check if the email already exists
        $checkEmailQuery = "SELECT user_id FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $checkEmailQuery);
        if (mysqli_num_rows($result) > 0) {
            // Email already exists, handle the situation accordingly
            echo "<script> alert('Email already exists.'); </script>";
        } else {
            // Email does not exist, proceed with insertion
            $insertQuery = "INSERT INTO user (first_name, last_name, email, password, phone_number, country) VALUES ('$firstName', '$lastName', '$email', '$password', '$phoneNumber', '$country')";
            mysqli_query($conn, $insertQuery);
        }
    } elseif (isset($_POST['deleteUser'])) {
        $userId = $_POST['userId'];
        $sql = "DELETE FROM user WHERE user_id = '$userId'";
        mysqli_query($conn, $sql);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteListing'])) {
    // Check if ad_id is set
    if (isset($_POST['ad_id'])) {
        // Get the ad_id from the form data
        $ad_id = $_POST['ad_id'];

        // Perform the deletion query (replace this with your actual deletion query)
        $deleteQuery = "DELETE FROM listing WHERE ad_id = $ad_id";

        // Execute the deletion query
        if (mysqli_query($conn, $deleteQuery)) {
            // Deletion successful
            echo "<script> alert('Listing deleted successfully.') </script>";
        } else {
            // Deletion failed
            echo "<script> alert('Error deleting listing:') </script>";
        }
    } else {
        // ad_id parameter not set
        echo "No ad_id specified.";
    }
}
$carouselID = 1;



$users = mysqli_query($conn, "SELECT * FROM user where user_role != 1");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Airbnb</title>
    <!-- Include any necessary CSS files -->
    <link rel="stylesheet" href="adminpage.css">
    <link rel="stylesheet" href="../home page/style.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../home page/style.css" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="../Home Page/homepage.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <!-- Header section -->
    <header>
        <h1>Admin Dashboard</h1>
        <!-- Navigation menu -->
        <nav>
            <ul>
                <li><a href="../Home Page/admin.php">Home</a></li>
                <li><a href="#">Users</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main content section -->
    <main>
        <!-- User management section -->
        <section id="user-management">
            <h2>User Management</h2>
            <!-- User management controls -->
            <div>
                <form action="" method="POST" style="display:inline;">
                    <input type="text" name="firstName" placeholder="First Name" required>
                    <input type="text" name="lastName" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="number" name="phoneNumber" placeholder="Phone Number" required>
                    <select id="country" name="country" class="form-select" required>
                        <option value="" disabled selected>Country</option>
                        <option value="Afghanistan">Afghanistan</option>
                        <option value="Åland Islands">Åland Islands</option>
                        <option value="Albania">Albania</option>
                        <option value="Algeria">Algeria</option>
                        <option value="American Samoa">American Samoa</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Angola">Angola</option>
                        <option value="Anguilla">Anguilla</option>
                        <option value="Antarctica">Antarctica</option>
                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                        <option value="Argentina">Argentina</option>
                        <option value="Armenia">Armenia</option>
                        <option value="Aruba">Aruba</option>
                        <option value="Australia">Australia</option>
                        <option value="Austria">Austria</option>
                        <option value="Azerbaijan">Azerbaijan</option>
                        <option value="Bahamas">Bahamas</option>
                        <option value="Bahrain">Bahrain</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Barbados">Barbados</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Belgium">Belgium</option>
                        <option value="Belize">Belize</option>
                        <option value="Benin">Benin</option>
                        <option value="Bermuda">Bermuda</option>
                        <option value="Bhutan">Bhutan</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                        <option value="Botswana">Botswana</option>
                        <option value="Bouvet Island">Bouvet Island</option>
                        <option value="Brazil">Brazil</option>
                        <option value="British Indian Ocean Territory">British Indian Ocean
                            Territory</option>
                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                        <option value="Bulgaria">Bulgaria</option>
                        <option value="Burkina Faso">Burkina Faso</option>
                        <option value="Burundi">Burundi</option>
                        <option value="Cambodia">Cambodia</option>
                        <option value="Cameroon">Cameroon</option>
                        <option value="Canada">Canada</option>
                        <option value="Cape Verde">Cape Verde</option>
                        <option value="Cayman Islands">Cayman Islands</option>
                        <option value="Central African Republic">Central African Republic</option>
                        <option value="Chad">Chad</option>
                        <option value="Chile">Chile</option>
                        <option value="China">China</option>
                        <option value="Christmas Island">Christmas Island</option>
                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                        <option value="Colombia">Colombia</option>
                        <option value="Comoros">Comoros</option>
                        <option value="Congo">Congo</option>
                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic
                            Republic of The</option>
                        <option value="Cook Islands">Cook Islands</option>
                        <option value="Costa Rica">Costa Rica</option>
                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                        <option value="Croatia">Croatia</option>
                        <option value="Cuba">Cuba</option>
                        <option value="Cyprus">Cyprus</option>
                        <option value="Czech Republic">Czech Republic</option>
                        <option value="Denmark">Denmark</option>
                        <option value="Djibouti">Djibouti</option>
                        <option value="Dominica">Dominica</option>
                        <option value="Dominican Republic">Dominican Republic</option>
                        <option value="Ecuador">Ecuador</option>
                        <option value="Egypt">Egypt</option>
                        <option value="El Salvador">El Salvador</option>
                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                        <option value="Eritrea">Eritrea</option>
                        <option value="Estonia">Estonia</option>
                        <option value="Ethiopia">Ethiopia</option>
                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)
                        </option>
                        <option value="Faroe Islands">Faroe Islands</option>
                        <option value="Fiji">Fiji</option>
                        <option value="Finland">Finland</option>
                        <option value="France">France</option>
                        <option value="French Guiana">French Guiana</option>
                        <option value="French Polynesia">French Polynesia</option>
                        <option value="French Southern Territories">French Southern Territories
                        </option>
                        <option value="Gabon">Gabon</option>
                        <option value="Gambia">Gambia</option>
                        <option value="Georgia">Georgia</option>
                        <option value="Germany">Germany</option>
                        <option value="Ghana">Ghana</option>
                        <option value="Gibraltar">Gibraltar</option>
                        <option value="Greece">Greece</option>
                        <option value="Greenland">Greenland</option>
                        <option value="Grenada">Grenada</option>
                        <option value="Guadeloupe">Guadeloupe</option>
                        <option value="Guam">Guam</option>
                        <option value="Guatemala">Guatemala</option>
                        <option value="Guernsey">Guernsey</option>
                        <option value="Guinea">Guinea</option>
                        <option value="Guinea-bissau">Guinea-bissau</option>
                        <option value="Guyana">Guyana</option>
                        <option value="Haiti">Haiti</option>
                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald
                            Islands</option>
                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)
                        </option>
                        <option value="Honduras">Honduras</option>
                        <option value="Hong Kong">Hong Kong</option>
                        <option value="Hungary">Hungary</option>
                        <option value="Iceland">Iceland</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                        <option value="Iraq">Iraq</option>
                        <option value="Ireland">Ireland</option>
                        <option value="Isle of Man">Isle of Man</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Jamaica">Jamaica</option>
                        <option value="Japan">Japan</option>
                        <option value="Jersey">Jersey</option>
                        <option value="Jordan">Jordan</option>
                        <option value="Kazakhstan">Kazakhstan</option>
                        <option value="Kenya">Kenya</option>
                        <option value="Kiribati">Kiribati</option>
                        <option value="Korea, Democratic People's Republic of">Korea, Democratic
                            People's Republic of</option>
                        <option value="Korea, Republic of">Korea, Republic of</option>
                        <option value="Kuwait">Kuwait</option>
                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                        <option value="Lao People's Democratic Republic">Lao People's Democratic
                            Republic</option>
                        <option value="Latvia">Latvia</option>
                        <option value="Lebanon">Lebanon</option>
                        <option value="Lesotho">Lesotho</option>
                        <option value="Liberia">Liberia</option>
                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lithuania">Lithuania</option>
                        <option value="Luxembourg">Luxembourg</option>
                        <option value="Macao">Macao</option>
                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The
                            Former Yugoslav Republic of</option>
                        <option value="Madagascar">Madagascar</option>
                        <option value="Malawi">Malawi</option>
                        <option value="Malaysia">Malaysia</option>
                        <option value="Maldives">Maldives</option>
                        <option value="Mali">Mali</option>
                        <option value="Malta">Malta</option>
                        <option value="Marshall Islands">Marshall Islands</option>
                        <option value="Martinique">Martinique</option>
                        <option value="Mauritania">Mauritania</option>
                        <option value="Mauritius">Mauritius</option>
                        <option value="Mayotte">Mayotte</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Micronesia, Federated States of">Micronesia, Federated States
                            of</option>
                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                        <option value="Monaco">Monaco</option>
                        <option value="Mongolia">Mongolia</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Montserrat">Montserrat</option>
                        <option value="Morocco">Morocco</option>
                        <option value="Mozambique">Mozambique</option>
                        <option value="Myanmar">Myanmar</option>
                        <option value="Namibia">Namibia</option>
                        <option value="Nauru">Nauru</option>
                        <option value="Nepal">Nepal</option>
                        <option value="Netherlands">Netherlands</option>
                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                        <option value="New Caledonia">New Caledonia</option>
                        <option value="New Zealand">New Zealand</option>
                        <option value="Nicaragua">Nicaragua</option>
                        <option value="Niger">Niger</option>
                        <option value="Nigeria">Nigeria</option>
                        <option value="Niue">Niue</option>
                        <option value="Norfolk Island">Norfolk Island</option>
                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                        <option value="Norway">Norway</option>
                        <option value="Oman">Oman</option>
                        <option value="Pakistan">Pakistan</option>
                        <option value="Palau">Palau</option>
                        <option value="Palestinian Territory, Occupied">Palestinian Territory,
                            Occupied</option>
                        <option value="Panama">Panama</option>
                        <option value="Papua New Guinea">Papua New Guinea</option>
                        <option value="Paraguay">Paraguay</option>
                        <option value="Peru">Peru</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Pitcairn">Pitcairn</option>
                        <option value="Poland">Poland</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Puerto Rico">Puerto Rico</option>
                        <option value="Qatar">Qatar</option>
                        <option value="Reunion">Reunion</option>
                        <option value="Romania">Romania</option>
                        <option value="Russian Federation">Russian Federation</option>
                        <option value="Rwanda">Rwanda</option>
                        <option value="Saint Helena">Saint Helena</option>
                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                        <option value="Saint Lucia">Saint Lucia</option>
                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The
                            Grenadines</option>
                        <option value="Samoa">Samoa</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                        <option value="Saudi Arabia">Saudi Arabia</option>
                        <option value="Senegal">Senegal</option>
                        <option value="Serbia">Serbia</option>
                        <option value="Seychelles">Seychelles</option>
                        <option value="Sierra Leone">Sierra Leone</option>
                        <option value="Singapore">Singapore</option>
                        <option value="Slovakia">Slovakia</option>
                        <option value="Slovenia">Slovenia</option>
                        <option value="Solomon Islands">Solomon Islands</option>
                        <option value="Somalia">Somalia</option>
                        <option value="South Africa">South Africa</option>
                        <option value="South Georgia and The South Sandwich Islands">South Georgia
                            and The South Sandwich Islands</option>
                        <option value="Spain">Spain</option>
                        <option value="Sri Lanka">Sri Lanka</option>
                        <option value="Sudan">Sudan</option>
                        <option value="Suriname">Suriname</option>
                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                        <option value="Swaziland">Swaziland</option>
                        <option value="Sweden">Sweden</option>
                        <option value="Switzerland">Switzerland</option>
                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Tajikistan">Tajikistan</option>
                        <option value="Tanzania, United Republic of">Tanzania, United Republic of
                        </option>
                        <option value="Thailand">Thailand</option>
                        <option value="Timor-leste">Timor-leste</option>
                        <option value="Togo">Togo</option>
                        <option value="Tokelau">Tokelau</option>
                        <option value="Tonga">Tonga</option>
                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                        <option value="Tunisia">Tunisia</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Turkmenistan">Turkmenistan</option>
                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                        <option value="Tuvalu">Tuvalu</option>
                        <option value="Uganda">Uganda</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                        <option value="United States Minor Outlying Islands">United States Minor
                            Outlying Islands</option>
                        <option value="Uruguay">Uruguay</option>
                        <option value="Uzbekistan">Uzbekistan</option>
                        <option value="Vanuatu">Vanuatu</option>
                        <option value="Venezuela">Venezuela</option>
                        <option value="Viet Nam">Viet Nam</option>
                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                        <option value="Western Sahara">Western Sahara</option>
                        <option value="Yemen">Yemen</option>
                        <option value="Zambia">Zambia</option>
                        <option value="Zimbabwe">Zimbabwe</option>
                    </select>
                    <button type="submit" name="addUser">Add User</button>
                </form>
            </div>
            <!-- User list -->
            <ul>
                <?php while ($row = mysqli_fetch_assoc($users)) { ?>
                    <li>
                        <?php echo $row['first_name'] . " " . $row['last_name']; ?> (ID: <?php echo $row['user_id']; ?>)
                        <form action="" method="POST" style="display:inline;">
                            <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                            <button type="submit" name="deleteUser">Delete</button>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        </section>

        <!-- Listing management section -->
        <section id="listing-management">
            <h2>Listing Management</h2>
            <div>
                <form method="GET" action="adminHosting.php">
                    <div class="mb-3">
                        <label for="userId" class="form-label">Select User:</label>
                        <select class="form-select" id="userId" name="user_id" required>
                            <?php
                            // Fetch user data from the database
                            $usersQuery = "SELECT user_id, first_name, last_name FROM user WHERE user_role != 1";
                            $usersResult = mysqli_query($conn, $usersQuery);

                            if (mysqli_num_rows($usersResult) > 0) {
                                while ($userRow = mysqli_fetch_assoc($usersResult)) {
                                    $userId = $userRow['user_id'];
                                    $userName = $userRow['first_name'] . " " . $userRow['last_name'];
                            ?>
                                    <option value="<?php echo $userId; ?>"><?php echo $userName; ?></option>
                            <?php
                                }
                            } else {
                                echo "<option disabled>No users found</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="mb-3">Proceed to Add Listing</button>
                </form>

                <button>Edit Listing</button>
            </div>
            <!-- Listing list -->
            <ul>
                <?php
                // Fetch listings data including user's name
                $listingsQuery = "SELECT listing.ad_id,listing.ad_title, listing.rent_price, listing.file_path, listing.upload_directory, user.first_name, user.last_name FROM listing INNER JOIN user ON listing.user_id = user.user_id";
                $listingsResult = mysqli_query($conn, $listingsQuery);
                $listingsResult = mysqli_query($conn, $listingsQuery);
                if (mysqli_num_rows($listingsResult) > 0) {
                    while ($row = mysqli_fetch_assoc($listingsResult)) {
                        $listingId = $row['ad_id'];
                        $listingTitle = $row['ad_title'];
                        $price = $row['rent_price'];
                        $pictureFileNames = json_decode($row['file_path'], true);
                        $userName = $row['first_name'] . " " . $row['last_name'];
                        $uploadDirectory = $row['upload_directory'];
                        if (is_dir($uploadDirectory)) {
                            $images = glob($uploadDirectory . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
                            $imageSets = array_chunk($images, 5);
                            foreach ($imageSets as $imageSet) {
                ?>
                                <div class="col-md-4">
                                    <div class="card mb-4">
                                        <div id="Listing<?php echo $carouselID; ?>Carousel" class="carousel slide" data-bs-ride="carousel">
                                            <ol class="carousel-indicators">
                                                <?php
                                                for ($i = 0; $i < count($imageSet); $i++) {
                                                    $active = ($i === 0) ? 'active' : '';
                                                ?>
                                                    <li data-target="#Listing<?php echo $carouselID; ?>Carousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $active; ?>"></li>
                                                <?php } ?>
                                            </ol>
                                            <div class="carousel-inner">
                                                <?php
                                                foreach ($imageSet as $key => $image) {
                                                    $active = ($key === 0) ? 'active' : '';
                                                ?>
                                                    <div class="item <?php echo $active; ?>">
                                                        <img src="<?php echo $image; ?>" alt="Listing Image">
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <a class="left carousel-control" href="#Listing<?php echo $carouselID; ?>Carousel" data-slide="prev">
                                                <span class="glyphicon glyphicon-chevron-left"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="right carousel-control" href="#Listing<?php echo $carouselID; ?>Carousel" data-slide="next">
                                                <span class="glyphicon glyphicon-chevron-right"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <li>
                                                Listing ID: <?php echo $listingId; ?><br>
                                                Listing Title: <?php echo $listingTitle; ?><br>
                                                Price: <?php echo $price; ?><br>
                                                Created by: <?php echo $userName; ?>
                                            </li>
                                            <form id="deleteListing" method="POST">
                                                <input type="hidden" name="ad_id" value="<?php echo $row['ad_id']; ?>">
                                                <button type="submit" class="btn btn-danger" name="deleteListing" onclick="return confirm('Are you sure you want to delete this listing?')">Delete Listing</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                <?php
                                $carouselID++;
                            }
                        }
                    }
                } else {
                    echo "No listings found.";
                }
                ?>
            </ul>
        </section>


        <!-- Booking management section -->
        <section id="booking-management">
            <h2>Booking Management</h2>
            <!-- Booking management controls -->
            <div>
                <button>Approve Booking</button>
                <button>Reject Booking</button>
                <button>Cancel Booking</button>
            </div>

            <!-- Booking list -->
            <ul>
                <li>Booking 1</li>
                <li>User 1</li>
                <li>Date</li>
                <hr>
                <li>Booking 2</li>
                <li>User 2</li>
                <li>Date</li>
                <hr>
                <li>Booking 3</li>
                <li>User 3</li>
                <li>Date</li>
                <hr>
            </ul>
        </section>
    </main>

    <!-- Footer section -->
    <footer>
        <p>&copy; 2024 Airbnb. All rights reserved.</p>
    </footer>
</body>

</html>