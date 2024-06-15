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
    $username = $_POST["username"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $court = $_POST["court"];
    $username = mysqli_real_escape_string($conn, $username);

    $query = "DELETE FROM booking WHERE username = '$username' AND time = '$time' AND date = '$date' AND court = '$court'";

if (mysqli_query($conn, $query)) {
    echo "done";
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

    
}

else {
    echo"error";
}

// Close the database connection
mysqli_close($conn);
?>
