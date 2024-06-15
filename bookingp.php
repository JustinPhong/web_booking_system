<?php
$host = "sql207.infinityfree.com";
$username = "if0_35750405";
$password = "FQaTai5cwU1";
$dbname = "if0_35750405_sportcenter";

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
    $transformedUsername = ucwords(str_replace('%20',' ',$transformedUsername));

    // Proceed to select booking information for the given username
    $bookingQuery = "SELECT * FROM booking WHERE username = ?";
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
    // Redirect or handle the case where the username parameter is not set
    echo "Username parameter is not set in the URL.";
}

// Close the database connection
mysqli_close($conn);
?>




<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <title>No Booking</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arsenal%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed%3A700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=B612%3A700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A400%2C700"/>
  <link rel="stylesheet" href="./styles/no-booking.css"/>
<script>

    function redirectToCourtBooking() {
    // Retrieve the username from sessionStorage
    var username = sessionStorage.getItem('username');

    // Redirect to court-booking.php with the username parameter
    window.location.href = "/court-booking.php?username=" + encodeURIComponent(username);
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Retrieve the stored value from sessionStorage
    var username = sessionStorage.getItem('username');

    // Check if the username is not null or undefined
    if (username) {
      // Get the element with class 'phong-yen-hou-1PT'
      var usernameElement = document.querySelector('.phong-yen-hou-1PT');

      // Update the content of the element with the transformed username
      if (usernameElement) {
        usernameElement.textContent = "<?php echo $transformedUsername; ?>";
      }
    }

    // Retrieve the booking data from PHP to JavaScript
    var bookingData = <?php echo json_encode($bookingData); ?>;
    var maxBookings = 7;

  // Loop through each booking number
  for (let i = 0; i < maxBookings; i++) {
    var bookedElement = document.querySelector('.booked' + (i + 1));

    // Check if there is booking data for this index and the booked element exists
    if (bookingData && bookingData[i] && bookedElement) {
      var bdate = bookingData[i].date;
      var btime = bookingData[i].time;
      var bcourt = bookingData[i].court;

      // Set the style to block to display the booked element
      bookedElement.style.display = 'block';

      var dateElement = document.querySelector('.date' + (i + 1));
      var timeElement = document.querySelector('.time' + (i + 1));
      var courtElement = document.querySelector('.court' + (i + 1));

      // Check if dateElement, timeElement, and courtElement exist before updating styles
      if (dateElement && timeElement && courtElement) {
        // Update the content of the elements with booking details
        dateElement.textContent = bdate;
        timeElement.textContent = btime;
        courtElement.textContent = bcourt;
      } else {
        console.error('Error: Some elements do not exist.');
      }
    } else {
      // No booking data for this index or booked element does not exist, hide the booked element
      if (bookedElement) {
        bookedElement.style.display = 'none';
      } else {
        console.error('Error: Booked element does not exist.');
      }
    }
  }

  // Loop through each booking number
for (let i = 0; i < maxBookings; i++) {
  var cancelBtn = document.querySelector('.cancelb' + (i + 1));

  if (cancelBtn) {
    // Add click event listener to Cancel button
    cancelBtn.addEventListener('click', function () {
      // Get the date, time, and court information from the clicked element
      var date = bookingData[i].date;
      var time = bookingData[i].time;
      var court = bookingData[i].court;

      // Call the function to delete the booking
      cancelBooking(date, time, court);
    });
  }
}
  });

      function cancelBooking(date, time, court) {
  // Retrieve the username from sessionStorage
  var username = sessionStorage.getItem('username');

  // Send an asynchronous request to delete-booking.php
  var xhr = new XMLHttpRequest();
  xhr.open("POST", "delete-booking.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Define the data to be sent, including booking details
  var data = "username=" + encodeURIComponent(username) +
             "&date=" + encodeURIComponent(date) +
             "&time=" + encodeURIComponent(time) +
             "&court=" + encodeURIComponent(court);

  // Set up the callback function
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        // Handle the response from the server if needed
        console.log(xhr.responseText);
        // Reload the page or update the UI as needed
        location.reload();
      } else {
        // Handle the error
        console.error("Error deleting booking: " + xhr.statusText);
      }
    }
  };

  // Send the request with the data
  xhr.send(data);
}
</script>


</head>
<body>

<div class="no-booking-dgR">
  <div class="navi-BC9">
    <div class="navi-jDf">
    </div>
    <img class="image-1-GzH" src="./assets/image-1.png"/>
    <div class="rectangle-2-Qqb">
    </div>
    <div class="group-1-MVw">
      <a href="/home.html">
      <div class="navigation-g2R">HOME</div>
      </a>
      <a href="#" onclick="redirectToCourtBooking()" class="court-booking-z37">COURT BOOKING</a>
      <a href="/directory.html">
      <div class="navigation-ijo">DIRECTORY</div>
      </a>
      <a href="/about-us.html">
      <div class="navigation-Sfo">ABOUT US</div>
      </a>
    </div>
    <p class="booking-court-Arh">COURT BOOKING</p>
  </div>
  <img class="image-3-gKF" src="./assets/image-3-nUd.png"/>
  <div class="auto-group-eal5-pAZ">
    <div class="rectangle-4-k4D">
    </div>
    <div class="rectangle-5-hEM">
    </div>
    <p class="manage-booking-DCh">Manage Booking</p>
    <a href="#" onclick="redirectToCourtBooking()" class="item--KFj">&lt;</a>
    <p class="phong-yen-hou-1PT">PHONG YEN HOU</p>
    <a href="logout.html" class="logout-iof">Logout</a>
    <p class="no-booking-E1K">No Booking</p>

<div class="booked1">
  <div class="rectangle-28-H1P1"></div>
  <p class="date1">11</p>
  <p class="datet1"> January 2024  </p>
  <p class="time1">8:00am - 9:00am</p>
  <p class="court1"> Court </p>
  <div class="cancelb1">
    <div class="rectangle-29-Jx51"></div>
    <p class="cancel-3Ps1">Cancel</p>
  </div>
</div>

<div class="booked2">
  <div class="rectangle-28-H1P2"></div>
  <p class="date2">11</p>
  <p class="datet2"> January 2024  </p>
  <p class="time2">8:00am - 9:00am</p>
  <p class="court2"> Court </p>
  <div class="cancelb2">
    <div class="rectangle-29-Jx52"></div>
    <p class="cancel-3Ps2">Cancel</p>
  </div>
</div>

<div class="booked3">
  <div class="rectangle-28-H1P3"></div>
  <p class="date3">11</p>
  <p class="datet3"> January 2024  </p>
  <p class="time3">8:00am - 9:00am</p>
  <p class="court3"> Court </p>
  <div class="cancelb3">
    <div class="rectangle-29-Jx53"></div>
    <p class="cancel-3Ps3">Cancel</p>
  </div>
</div>

<div class="booked4">
  <div class="rectangle-28-H1P4"></div>
  <p class="date4">11</p>
  <p class="datet4"> January 2024  </p>
  <p class="time4">8:00am - 9:00am</p>
  <p class="court4"> Court </p>
  <div class="cancelb4">
    <div class="rectangle-29-Jx54"></div>
    <p class="cancel-3Ps4">Cancel</p>
  </div>
</div>


  </div>
  <div class="footer-vPw">
    <img class="footer-rHb" src="./assets/footer-u4q.png"/>
    <div class="auto-group-apkd-Nmj">
      <p class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--Wd3">
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--Wd3-sub-0">
        SPORTS CENTRE
        <br/>
        Universiti Utara Malaysia
        <br/>
        
        </span>
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--Wd3-sub-1">
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
      <div class="group-9-R1F">
        <a class="group-4-YLm" href="https://www.uum.edu.my/getting-to-uum">Getting to UUM</a>
        <a class="group-5-3YR" href="https://uum.edu.my/360/">Virtual Tour</a>
        <a class="group-4-mUR" href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">Campus Map</a>
        <a class="group-6-HBs" href="https://www.uum.edu.my/campus-life/services/one-stop-centre">Contact Us</a>
        <a class="group-7-17s" href="https://www.youtube.com/channel/UC4jmFEb5BkSdAHvDuXebDXA">Youtube</a>
        <a class="group-8-KuF" href="https://www.facebook.com/uumsportscentre">Facebook</a>
      </div>
      <div class="group-2-eRj">
      <a href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">
        <img class="image-2-brm" src="./assets/image-2-U5T.png"/>
        </a>
        <p class="universiti-utara-malaysia-vu3">© 2024 Universiti Utara Malaysia</p>
      </div>
    </div>
  </div>
</div>
</body>