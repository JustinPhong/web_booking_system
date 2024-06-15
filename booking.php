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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from the form
    $date = $_POST["date"];
    $time = $_POST["time"];
    $court = $_POST["court"];
    $username = $_POST["username"];

    // Validate and sanitize the input (you may need additional validation)
    $date = mysqli_real_escape_string($conn, $date);
    $time = mysqli_real_escape_string($conn, $time);
    $court = mysqli_real_escape_string($conn, $court);
    $username = mysqli_real_escape_string($conn, $username);

    // Insert data into the 'booking' table (replace 'booking' with your actual table name)
    $query = "INSERT INTO booking (date, time, court, username) VALUES ('$date', '$time', '$court', '$username')";

    if (mysqli_query($conn, $query)) {
        // Redirect to bookingp.php with the username as a parameter in the URL
        header("Location: /bookingp.php?username=" . urlencode($username));
        exit();
    } else {
        echo "Error confirming booking: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
