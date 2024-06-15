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

// Check if the username, date, time, and court parameters are set in the request
if (isset($_POST['username']) && isset($_POST['date']) &&
    isset($_POST['time']) && isset($_POST['court'])) {

    // Get the username, date, time, and court from the request
    $username = $_POST['username'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $court = $_POST['court'];

    // Transform the username to "Aaa Bb C" format
    $transformedUsername = ucwords(str_replace('_', ' ', $username));
    $transformedUsername = ucwords(str_replace('%20',' ',$transformedUsername));

    // Proceed to delete the corresponding booking information
    $deleteQuery = "DELETE FROM booking WHERE username = ? AND date = ? AND time = ? AND court = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($deleteStmt, "ssss", $transformedUsername, $date, $time, $court);
    mysqli_stmt_execute($deleteStmt);

    // Check if the deletion was successful
    if (mysqli_affected_rows($conn) > 0) {
        echo "Booking canceled successfully!";
    } else {
        echo "Error canceling booking: " . mysqli_error($conn);
    }

    mysqli_stmt_close($deleteStmt);
} else {
    echo "Username, date, time, or court parameters are not set in the request.";
}

// Close the database connection
mysqli_close($conn);
?>
