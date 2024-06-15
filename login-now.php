<?php
$host = "sql207.infinityfree.com";
$username = "if0_35750405";
$password = "FQaTai5cwU1";
$dbname = "if0_35750405_sportcenter";

// Create a MySQLi connection
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the connection
if (mysqli_connect_error()) {
    die("Connection could not be established: " . mysqli_connect_error());
}

// Check if the username parameter is set in the URL
if (isset($_GET['username'])) {
    // Get the username from the URL
    $urlUsername = $_GET['username'];

    // Transform the username to "Aaa Bb C" format
    $transformedUsername = ucwords(str_replace('_', ' ', $urlUsername));
    $transformedUsername = ucwords(str_replace('%20', ' ', $transformedUsername));
    $transformedUsername = ucwords(str_replace('+', ' ', $transformedUsername));

 // Check if the user has booked 4 times
$bookingCount = getBookingCount($conn, $transformedUsername);

// Check if the user has booked on the specified date
$dateToCheck = $_GET['date']; // Make sure to set 'clickedDate' in your session
$hasBookedOnDate = hasBookedOnDate($conn, $transformedUsername, $dateToCheck);

if ($bookingCount >= 4 || $hasBookedOnDate) {
    // Disable the booking or handle it as needed
    // You can send a flag to the JavaScript indicating whether to disable the button
    echo '<script>var disableBooking = true;</script>';
} else {
    // Continue with your existing code
    // ...

    // Print the JavaScript variable to the HTML
    echo '<script>var disableBooking = false;</script>';
}


    // Proceed to select booking information for the given username
    $bookingQuery = "SELECT * FROM booking WHERE username = ?";

    // Check if the connection is still open before preparing the statement
    if ($conn) {
        $bookingStmt = mysqli_prepare($conn, $bookingQuery);
        mysqli_stmt_bind_param($bookingStmt, "s", $transformedUsername);
        mysqli_stmt_execute($bookingStmt);

        $result = mysqli_stmt_get_result($bookingStmt);

        if ($result) {
            // Fetch the result into a PHP associative array
            $bookingData = array();

            while ($row = mysqli_fetch_assoc($result)) {
                $bookingData[] = array(
                    'date' => $row["date"],
                    'time' => $row["time"],
                    'court' => $row["court"]
                );
            }

            // Now $bookingData contains the booking information as a PHP array

            // You can use $bookingData as needed
            // For example, you can echo it, manipulate it, or perform other actions
        } else {
            // Query execution error for booking information
            echo "Error executing booking query: " . mysqli_error($conn);
        }

        mysqli_stmt_close($bookingStmt);
    } else {
        echo "Database connection is closed.";
    }

    // Close the connection after you have finished using it
    mysqli_close($conn);


} else {
    // Redirect or handle the case where the username parameter is not set
    echo "Username parameter is not set in the URL.";
}

// Function to get the booking count for a user
function getBookingCount($conn, $transformedUsername) {
    $query = "SELECT COUNT(*) AS count FROM booking WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $transformedUsername);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];
    mysqli_stmt_close($stmt);
    return $count;
}

// Function to check if a user has booked on a specific date
function hasBookedOnDate($conn, $transformedUsername, $date) {
    $query = "SELECT COUNT(*) AS count FROM booking WHERE username = ? AND date = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $transformedUsername, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];
    mysqli_stmt_close($stmt);
    return $count > 0;
}

// Print debug output
echo '<script>console.log("Booking Count: ' . $bookingCount . '");</script>';
echo '<script>console.log("Has Booked on Date: " + ' . ($hasBookedOnDate? 'true' : 'false') . ');</script>';
echo '<script>console.log("Disable Booking: " + ' . ($disableBooking ? 'true' : 'false') . ');</script>';

?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <title>Login Now</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=B612%3A700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arsenal%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed%3A700"/>
  <link rel="stylesheet" href="./styles/login-now.css"/>
    <script>
      function redirectToCourtBooking() {
    // Retrieve the username from sessionStorage
    var username = sessionStorage.getItem('username');

    // Redirect to court-booking.php with the username parameter
    window.location.href = "/court-booking.php?username=" + encodeURIComponent(username);
  }
document.addEventListener('DOMContentLoaded', function () {
    sessionStorage.setItem('onpage', 'True');

    // Retrieve the stored date from sessionStorage
    var storedTime = sessionStorage.getItem('clickedTime');
    var storedDate = sessionStorage.getItem('clickedDate');
    var storedCourt = sessionStorage.getItem('clickedCourt');

    // Update the date element if a date is stored
    if (storedDate) {
        var dateElement = document.querySelector('.am-9-00am-syo');
        var dateElement1 = document.querySelector('.december-2023-Hkh');
        var dateElement2 = document.querySelector('.court-1-izR');

        if (dateElement) {
            dateElement.textContent = storedTime;
            dateElement1.textContent = storedDate + " January 2024";
            dateElement2.textContent = storedCourt;
        }
    }

    // Retrieve the stored value from sessionStorage
    var username = sessionStorage.getItem('username');
    var booked = sessionStorage.getItem('booked');

    document.getElementById('dateInput').value = storedDate;
    document.getElementById('timeInput').value = storedTime;
    document.getElementById('courtInput').value = storedCourt;
    document.getElementById('usernameInput').value = username;

    // Get the "LOGIN NOW" and "BOOK NOW" elements
    var loginNowElement = document.querySelector('.login-now1');
    var bookNowElement = document.querySelector('.book-now');
    var clickedDate = sessionStorage.getItem('clickedDate');

    // Check if the username is null and update visibility accordingly
    if (username === null) {
        // Show "LOGIN NOW" and hide "BOOK NOW"
        loginNowElement.style.display = 'block';
        bookNowElement.style.display = 'none';
    } else {
        // Show "BOOK NOW" and hide "LOGIN NOW"
        loginNowElement.style.display = 'none';
        bookNowElement.style.display = 'block';


        // Get the "BOOK NOW" elements
        var bookNowButton = document.querySelector('.book-now-ZVF');

        // Check if the disableBooking variable is defined and true
        console.log('Disable Booking:', typeof disableBooking, disableBooking);
        
        if (typeof disableBooking !== 'undefined' && disableBooking) {
            // Disable the "BOOK NOW" button
            // Optionally, add a class to style the disabled button
            bookNowButton.classList.add('disabled');

            // Add a click event listener to display an alert when the disabled button is clicked
            bookNowButton.addEventListener('click', function (event) {
                event.preventDefault(); // Prevent the form from submitting
                alert("You have booked on this day or you have reached the maximum booking of 4. \n\nPlease check on manage booking page.");
                window.location.href = '/bookingp.php?username=' + encodeURIComponent(username);


            });
        }
    }
});

    </script>
</head>
<body>
<div class="login-now-goX">
  <div class="navi-peq">
    <div class="navi-yXj">
    </div>
    <img class="image-1-WnZ" src="./assets/image-1-BRF.png"/>
    <div class="rectangle-2-2W1">
    </div>
    <div class="group-1-mTb">
      <a href="/home.html">
      <div class="navigation-Gv9">HOME</div>
      </a>
      <a href="#" onclick="redirectToCourtBooking()" class="court-booking-mc1">COURT BOOKING</a>
      <a href="/directory.html">
      <div class="navigation-giy">DIRECTORY</div>
      </a>
      <a href="/about-us.html">
      <div class="navigation-zDs">ABOUT US</div>
      </a>
    </div>
    <p class="booking-court-i9s">COURT BOOKING</p>
  </div>
  <img class="image-3-bjT" src="./assets/image-3.png"/>
  <div class="auto-group-iaah-Xt1">
    <div class="rectangle-4-35f">
    </div>
    <div class="rectangle-5-arH">
    </div>
    <p class="december-2023-Hkh">11 December 2023</p>
    <a href="/court-selection15.php">
    <p class="item--P33">&lt;</p>
    </a>
    <p class="am-9-00am-syo">8:00am - 9:00am</p>
    <img class="image-4-z2q" src="./assets/image-4-gzh.png"/>
    <p class="court-1-izR">Court 1</p>

    <div class="login-now1">
    <a href="/uum-login.html">
    <p class="login-now-ZVF">LOGIN NOW</p>
    <div class="rectangle-21-qp9"></div>
    </a>
    </div>

    <div class="book-now">
      <form method="POST" action="booking.php">
        <input type="hidden" name="date" id="dateInput">
        <input type="hidden" name="time" id="timeInput">
        <input type="hidden" name="court" id="courtInput">
        <input type="hidden" name="username" id="usernameInput">
        <input class="rectangle-211-qp9 book-now-ZVF" type="submit" value="BOOK NOW">
      </form>
    </a>
  </div>
  <a href="#" onclick="redirectToCourtBooking()" class="cancel-bgq">CANCEL</a>
  <div href="#" onclick="redirectToCourtBooking()" class="rectangle-22-skq"></div>
  </div>
  <div class="footer-K73">
    <img class="footer-3Yq" src="./assets/footer-DUq.png"/>
    <div class="auto-group-bxmt-xA1">
      <p class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--h7b">
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--h7b-sub-0">
        SPORTS CENTRE
        <br/>
        Universiti Utara Malaysia
        <br/>
        
        </span>
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--h7b-sub-1">
        06010 Sintok
        <br/>
        Kedah Darul Aman, Malaysia
        <br/>
        📞 +604-928 3560/3551
        <br/>
        ✉️ pusur@uum.edu.my
        <br/>
        ...........................................................
        </span>
      </p>
      <div class="group-9-xbF">
        <a class="group-4-V5P" href="https://www.uum.edu.my/getting-to-uum">Getting to UUM</a>
        <a class="group-5-PgZ" href="https://uum.edu.my/360/">Virtual Tour</a>
        <a class="group-4-K4R" href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">Campus Map</a>
        <a class="group-6-qHf" href="https://www.uum.edu.my/campus-life/services/one-stop-centre">Contact Us</a>
        <a class="group-7-9ZF" href="https://www.youtube.com/channel/UC4jmFEb5BkSdAHvDuXebDXA">Youtube</a>
        <a class="group-8-sk9" href="https://www.facebook.com/uumsportscentre">Facebook</a>
      </div>
      <div class="group-2-15f">
        <a href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">
        <img class="image-2-m4q" src="./assets/image-2-RGy.png"/>
        </a>
        <p class="universiti-utara-malaysia-5bK">© 2024 Universiti Utara Malaysia</p>
      </div>
    </div>
  </div>
</div>
</body>