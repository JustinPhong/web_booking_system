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

    // Proceed to select booked dates for the given username
    $bookedDatesQuery = "SELECT DISTINCT date FROM booking WHERE username = ?";
    $bookedDatesStmt = mysqli_prepare($conn, $bookedDatesQuery);
    mysqli_stmt_bind_param($bookedDatesStmt, "s", $transformedUsername);
    mysqli_stmt_execute($bookedDatesStmt);

    $bookedDatesResult = mysqli_stmt_get_result($bookedDatesStmt);

    if ($bookedDatesResult) {
        // Fetch the booked dates into a PHP array
        $bookedDates = array();

        while ($row = mysqli_fetch_assoc($bookedDatesResult)) {
            $bookedDates[] = $row["date"];
        }

        // Now $bookedDates contains the booked dates for the user
    } else {
        // Query execution error for booked dates
        echo "Error executing booked dates query: " . mysqli_error($conn);
    }

    mysqli_stmt_close($bookedDatesStmt);
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <link rel="icon" href="/favicon.ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="theme-color" content="#000000" />
  <title>Court Booking</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=B612%3A700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Arsenal%3A400%2C700"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap+Condensed%3A700"/>
  <link rel="stylesheet" href="./styles/court-booking.css"/>
  <script>
document.addEventListener('DOMContentLoaded', function () {
    // Get all elements with class 'item-1-AsF' to 'item-1-TRf'
    var dateElements = document.querySelectorAll('.item-1-SWZ, .item-1-Aeq, .item-1-HHX, .item-1-Yo7, .item-1-Dy7, .item-1-g6q, .item-1-R1o');

    // Add click event listener to each date element
    dateElements.forEach(function (element) {
        element.addEventListener('click', function () {
            // Get the text content of the clicked element (date)
            var clickedDate = element.textContent;
            var bookedDates = <?php echo json_encode($bookedDates); ?>;

            // Check if the clicked date is in the bookedDates array
            if (bookedDates.includes(clickedDate)) {
                window.alert('You have already booked on this date. Please check Manage Booking.');
            } else {
                sessionStorage.setItem('clickedDate', clickedDate);
                window.location.href = "./time-selection15.html";
            }
        });
    });

    // Get the "Manage Booking" link
    var manageBookingLink = document.querySelector('.mange-booking-ZBj');

    // Add click event listener to the "Manage Booking" link
      document.querySelector('.mange-booking-ZBj').addEventListener('click', function () {
        // Check the value stored in sessionStorage
        var username = sessionStorage.getItem('username');

        // Redirect based on the condition (you can modify this condition as needed)
        if (username === null) {
          window.location.href = 'manage-booking.html';
        } else {
          // Include the username as a query parameter in the URL
          window.location.href = 'bookingp.php?username=' + encodeURIComponent(username);
        }
      });
    });

  </script>
</head>
<body>
<div class="court-booking-nh3">
  <div class="navi-j6V">
    <div class="navi-UJy">
    </div>
    <img class="image-1-1Ju" src="./assets/image-1-9aV.png"/>
    <div class="rectangle-2-LMB">
    </div>
    <div class="group-1-fuF">
      <a href="/home.html">
      <div class="navigation-C8V">HOME</div>
      </a>
      <p class="court-booking-5xy">COURT BOOKING</p>
      <a href="/directory.html">
      <div class="navigation-QEZ">DIRECTORY</div>
      </a>
      <a href="/about-us.html">
      <div class="navigation-hzM">ABOUT US</div>
      </a>
    </div>
    <p class="booking-court-pZB">COURT BOOKING</p>
  </div>
  <img class="image-3-iuT" src="./assets/image-3-3uw.png"/>
  <div class="auto-group-ipg5-3Rw">
    <div class="rectangle-4-aAy">
    </div>
    <div class="rectangle-5-7wb">
    </div>
    <p class="december-2023-Dzd">January 2024</p>
    <div class="frame-6-vu3">
      <div class="frame-2-FgR">
        <div class="date-aTo">
          <div class="rectangle-6-jbb">
          </div>
          <p class="item-1-Bc1">1</p>
        </div>
        <div class="date-szd">
          <div class="rectangle-6-qAm">
          </div>
          <p class="item-1-aPF">8</p>
        </div>
        <div class="date-gSH">
          <div class="rectangle-6-SgM">
          </div>
          <p class="item-1-AsF">15</p>
        </div>
        <div class="date-Ud3">
          <div class="rectangle-6-EMK">
          </div>
          <p class="item-1-Akm">22</p>
        </div>
        <div class="date-3Jm">
          <div class="rectangle-6-mkZ">
          </div>
          <p class="item-1-g6q">29</p>
        </div>
      </div>
      <div class="frame-3-LhB">
        <div class="date-rfX">
          <div class="rectangle-6-Qh3">
          </div>
          <p class="item-1-MMP">2</p>
        </div>
        <div class="date-UB7">
          <div class="rectangle-6-Rs3">
          </div>
          <p class="item-1-ydf">9</p>
        </div>
        <div class="date-gny">
          <div class="rectangle-6-eUu">
          </div>
          <p class="item-1-PSV">16</p>
        </div>
        <div class="date-6bo">
          <div class="rectangle-6-4Hj">
          </div>
          <p class="item-1-C93">23</p>
        </div>
        <div class="date-WQd">
          <div class="rectangle-6-4ww">
          </div>
          <p class="item-1-R1o">30</p>
        </div>
      </div>
      <div class="frame-2-RAD">
        <div class="date-kiH">
          <div class="rectangle-6-7Hw">
          </div>
          <p class="item-1-RpR">3</p>
        </div>
        <div class="date-8yj">
          <div class="rectangle-6-gkM">
          </div>
          <p class="item-1-d9o">10</p>
        </div>
        <div class="date-8cM">
          <div class="rectangle-6-63P">
          </div>
          <p class="item-1-qFs">17</p>
        </div>
        <div class="date-9XT">
          <div class="rectangle-6-uWd">
          </div>
          <p class="item-1-SWZ">24</p>
        </div>
        <div class="date-9vm">
          <div class="rectangle-6-WWR">
          </div>
          <p class="item-1-TRf">31</p>
        </div>
      </div>
      <div class="auto-group-xrms-ZzV">
        <div class="frame-4-uHf">
          <div class="date-SoP">
            <div class="rectangle-6-QVK">
            </div>
            <p class="item-1-x13">4</p>
          </div>
          <div class="date-fg9">
            <div class="rectangle-6-2Wh">
            </div>
            <p class="item-1-B8h">11</p>
          </div>
          <div class="date-V9P">
            <div class="rectangle-6-EMs">
            </div>
            <p class="item-1-kr1">18</p>
          </div>
          <div class="date-fi5">
            <div class="rectangle-6-Djb">
            </div>
            <p class="item-1-Aeq">25</p>
          </div>
          <div class="date-HUZ">
            <div class="rectangle-6-qky">
            </div>
          </div>
        </div>
        <div class="frame-2-bEM">
          <div class="date-8k5">
            <div class="rectangle-6-gWh">
            </div>
            <p class="item-1-dB3">5</p>
          </div>
          <div class="date-YJ1">
            <div class="rectangle-6-tsf">
            </div>
            <p class="item-1-qnu">12</p>
          </div>
          <div class="date-key">
            <div class="rectangle-6-7Ed">
            </div>
            <p class="item-1-TJV">19</p>
          </div>
          <div class="date-yGq">
            <div class="rectangle-6-L7P">
            </div>
            <p class="item-1-HHX">26</p>
          </div>
          <div class="date-Q7F">
            <div class="rectangle-6-MoB">
            </div>
          </div>
        </div>
        <div class="frame-5-i7w">
          <div class="date-qiM">
            <div class="rectangle-6-zbF">
            </div>
            <p class="item-1-Y6y">6</p>
          </div>
          <div class="date-Si9">
            <div class="rectangle-6-oYh">
            </div>
            <p class="item-1-YWH">13</p>
          </div>
          <div class="date-fL1">
            <div class="rectangle-6-Pmo">
            </div>
            <p class="item-1-w2d">20</p>
          </div>
          <div class="date-Szy">
            <div class="rectangle-6-Cz9">
            </div>
            <p class="item-1-Yo7">27</p>
          </div>
          <div class="date-TQH">
            <div class="rectangle-6-1gh">
            </div>
          </div>
        </div>
        <div class="frame-2-ZCR">
          <div class="date-tVb">
            <div class="rectangle-6-qfj">
            </div>
            <p class="item-1-PBT">7</p>
          </div>
          <div class="date-u9o">
            <div class="rectangle-6-GFF">
            </div>
            <p class="item-1-c4D">14</p>
          </div>
          <div class="date-XBB">
            <div class="rectangle-6-g45">
            </div>
            <p class="item-1-ouP">21</p>
          </div>
          <div class="date-Kcq">
            <div class="rectangle-6-5c1">
            </div>
            <p class="item-1-Dy7">28</p>
          </div>
          <div class="date-Lnq">
            <div class="rectangle-6-WBX">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="frame-1-3hF">
      <p class="monday-ZQh">Monday</p>
      <p class="tuesday-W53">Tuesday</p>
      <p class="wednesday-eS9">Wednesday</p>
      <p class="thursday-PPj">Thursday</p>
      <p class="friday-Y1j">Friday</p>
      <p class="saturday-gNq">Saturday</p>
      <p class="sunday-pE9">Sunday</p>
    </div>
    <a class="mange-booking-ZBj">Mange Booking</a>
  </div>
  <div class="footer-rRj">
    <img class="footer-ymF" src="./assets/footer-x45.png"/>
    <div class="auto-group-8dft-Hmw">
      <p class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--dqo">
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--dqo-sub-0">
        SPORTS CENTRE
        <br/>
        Universiti Utara Malaysia
        <br/>
        
        </span>
        <span class="sports-centre-universiti-utara-malaysia-06010-sintok-kedah-darul-aman-malaysia-604-928-3560-3551-pusuruumedumy--dqo-sub-1">
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
      <div class="group-9-f3j">
        <a class="group-4-BXs" href="https://www.uum.edu.my/getting-to-uum">Getting to UUM</a>
        <a class="group-5-gUd" href="https://uum.edu.my/360/">Virtual Tour</a>
        <a class="group-4-P89" href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">Campus Map</a>
        <a class="group-6-Vws" href="https://www.uum.edu.my/campus-life/services/one-stop-centre">Contact Us</a>
        <a class="group-7-ohf" href="https://www.youtube.com/channel/UC4jmFEb5BkSdAHvDuXebDXA">Youtube</a>
        <a class="group-8-7iM" href="https://www.facebook.com/uumsportscentre">Facebook</a>
      </div>
      <div class="group-2-2qK">
        <a href="https://www.openstreetmap.org/search?whereami=1&query=6.4635%2C100.5055#map=14/6.4635/100.5055&layers=N">
        <img class="image-2-BiD" src="./assets/image-2-MtH.png"/>
        </a>
        <p class="universiti-utara-malaysia-WEh">© 2024 Universiti Utara Malaysia</p>
      </div>
    </div>
  </div>
</div>
</body>