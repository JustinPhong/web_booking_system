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

// Fetch the booked dates, times, and courts
$bookedSlotsQuery = "SELECT date, time, court FROM booking";
$bookedSlotsStmt = mysqli_prepare($conn, $bookedSlotsQuery);
mysqli_stmt_execute($bookedSlotsStmt);

$bookedSlotsResult = mysqli_stmt_get_result($bookedSlotsStmt);

if ($bookedSlotsResult) {
    // Fetch the result into a PHP associative array
    $bookingData = array();

    while ($row = mysqli_fetch_assoc($bookedSlotsResult)) {
        $bookingData[] = array(
            'date' => $row["date"],
            'time' => $row["time"],
            'court' => $row["court"]
        );
    }

    // Now $bookingData contains the booked slots
} else {
    // Query execution error for booked slots
    echo "Error executing booked slots query: " . mysqli_error($conn);
}

mysqli_stmt_close($bookedSlotsStmt);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <title>Court Selection</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=B612%3A700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arsenal%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed%3A700"/>
  <link rel="stylesheet" href="./styles/court-selection.css"/>
  <script>
    function redirectToCourtBooking() {
    // Retrieve the username from sessionStorage
    var username = sessionStorage.getItem('username');

    // Redirect to court-booking.php with the username parameter
    window.location.href = "/court-booking.php?username=" + encodeURIComponent(username);
  }

    document.addEventListener('DOMContentLoaded', function () {
        // Add click event listener to the image with class 'image-4-psw'
        var image1Element = document.querySelector('.image-1-psw');
        var image2Element = document.querySelector('.image-2-psw');
        var image3Element = document.querySelector('.image-3-psw');
        var image4Element = document.querySelector('.image-4-psw');
        var image5Element = document.querySelector('.image-5-psw');
        var image6Element = document.querySelector('.image-6-psw');
        var image7Element = document.querySelector('.image-7-psw');
        var image8Element = document.querySelector('.image-8-psw');


if (image4Element && image5Element && image6Element && image7Element && image8Element && image3Element && image2Element && image1Element) {
  image8Element.addEventListener('click', function () {
    // Store "Court 3" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 5');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image7Element.addEventListener('click', function () {
    // Store "Court 4" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 6');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image6Element.addEventListener('click', function () {
    // Store "Court 5" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 7');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image5Element.addEventListener('click', function () {
    // Store "Court 1" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 8');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image4Element.addEventListener('click', function () {
    // Store "Court 2" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 4');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image3Element.addEventListener('click', function () {
    // Store "Court 3" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 3');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image2Element.addEventListener('click', function () {
    // Store "Court 4" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 2');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });

  image1Element.addEventListener('click', function () {
    // Store "Court 5" in sessionStorage when the image is clicked
    sessionStorage.setItem('clickedCourt', 'Court 1');
    window.location.href = "login-now.php?username=" + encodeURIComponent(sessionStorage.getItem('username')) + "&date=" + encodeURIComponent(sessionStorage.getItem('clickedDate'));
  });
}
});

    

      document.addEventListener('DOMContentLoaded', function () {
      // Retrieve the stored date from sessionStorage
      var storedTime = sessionStorage.getItem('clickedTime');
      var storedDate = sessionStorage.getItem('clickedDate');

      // Update the date element if a date is stored
      if (storedDate) {
        var dateElement = document.querySelector('.am-9-00am-pDj');
        var dateElement1 = document.querySelector('.december-2023-1GH');
        if (dateElement) {
          dateElement.textContent = storedTime;
          dateElement1.textContent = storedDate+" January 2024";

        }
      }


            // Fetch the booked slots for the specific date and time
            var bookedSlots = <?php echo json_encode($bookingData); ?>;

            // Loop through each court element and update its appearance based on the booking status
            for (var i = 1; i <= 8; i++) {
                var courtElement = document.querySelector('.image-' + i + '-psw'); // Replace with your actual class

                // Check if the current court is booked for the specific date and time
                var isBooked = bookedSlots.some(function (slot) {
                    return slot.date === storedDate && slot.time === storedTime && slot.court === 'Court ' + i;
                });

                // Update the appearance based on the booking status
                if (courtElement) {
                    if (isBooked) {
                        // The court is booked, so grey out the corresponding element
                        courtElement.style.opacity = '0.5'; // Set opacity to make it look greyed out
                        courtElement.style.pointerEvents = 'none'; // Disable click events
                    } else {
                        // The court is not booked, so reset the appearance
                        courtElement.style.opacity = '1'; // Reset opacity
                        courtElement.style.pointerEvents = 'auto'; // Enable click events
                    }
                }
            }

      
    });
</script>
</head>
<body>
<div class="court-selection-VbT">
  <div class="navi-EJ9">
    <div class="navi-ZrD">
    </div>
    <img class="image-1-WWZ" src="./assets/image-1-YCD.png"/>
    <div class="rectangle-2-Sf7">
    </div>
    <div class="group-1-zRj">
      <a href="/home.html">
      <div class="navigation-XAm">HOME</div>
      </a>
      <a href="#" onclick="redirectToCourtBooking()" class="court-booking-djb">COURT BOOKING</a>
      <a href="/directory.html">
      <div class="navigation-9xq">DIRECTORY</div>
      </a>
      <a href="/about-us.html">
      <div class="navigation-UVK">ABOUT US</div>
      </a>
    </div>
    <p class="booking-court-nku">COURT BOOKING</p>
  </div>
  <img class="image-3-HxZ" src="./assets/image-3-7q7.png"/>
  <div class="auto-group-kjdo-E77">
    <div class="rectangle-4-Z9P">
    </div>
    <div class="rectangle-5-6QD">
    </div>
    <p class="december-2023-1GH">15 January 2024</p>
    <a href="/time-selection15.html">
    <p class="item--Wiq">&lt;</p>
    </a>
    <p class="am-9-00am-pDj">8:00am - 9:00am</p>
    <div class="frame-19-Xdw">
      <img class="image-8-psw" src="./assets/image-4.png"/>
      <img class="image-7-psw" src="./assets/image-5.png"/>
      <img class="image-6-psw" src="./assets/image-6.png"/>
      <img class="image-5-psw" src="./assets/image-7.png"/>
    </div>
    <div class="frame-1-Xdw">
      <img class="image-1-psw" src="./assets/image-4.png"/>
      <img class="image-2-psw" src="./assets/image-5.png"/>
      <img class="image-3-psw" src="./assets/image-6.png"/>
      <img class="image-4-psw" src="./assets/image-7.png"/>
    </div>
    <div class="frame-20-KTK">
      <p class="court-1-2sX">Court 8</p>
      <p class="court-2-Z6m">Court 7</p>
      <p class="court-3-teq">Court 6</p>
      <p class="court-4-qa5">Court 5</p>
    </div>
    <div class="frame-2-KTK">
      <p class="court-5-2sX">Court 1</p>
      <p class="court-6-Z6m">Court 2</p>
      <p class="court-7-teq">Court 3</p>
      <p class="court-8-qa5">Court 4</p>
    </div>
    <p class="please-select-a-court-YDb">*Please select a court</p>
  </div>
  <div class="footer-F81">
    <img class="footer-NiR" src="./assets/footer-8rq.png"/>
    <div class="auto-group-xeub-6PX">
      <p class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--eA9">
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--eA9-sub-0">
        SPORTS CENTRE
        <br/>
        Universiti Utara Malaysia
        <br/>
        
        </span>
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--eA9-sub-1">
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
      <div class="group-9-KJD">
        <a class="group-4-e5b" href="https://www.uum.edu.my/getting-to-uum">Getting to UUM</a>
        <a class="group-5-ZCZ" href="https://uum.edu.my/360/">Virtual Tour</a>
        <a class="group-4-UKX" href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">Campus Map</a>
        <a class="group-6-bQ9" href="https://www.uum.edu.my/campus-life/services/one-stop-centre">Contact Us</a>
        <a class="group-7-hxy" href="https://www.youtube.com/channel/UC4jmFEb5BkSdAHvDuXebDXA">Youtube</a>
        <a class="group-8-S9s" href="https://www.facebook.com/uumsportscentre">Facebook</a>
      </div>
      <div class="group-2-Yyb">
        <a href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">
        <img class="image-2-WQd" src="./assets/image-2-rzZ.png"/>
        </a>
        <p class="universiti-utara-malaysia-3QZ">© 2024 Universiti Utara Malaysia</p>
      </div>
    </div>
  </div>
</div>
</body>