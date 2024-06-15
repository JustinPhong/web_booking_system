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

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username, password, and onpage from the form using $_POST
    $username = $_POST["username"];
    $password = $_POST["password"];
    $onpage = $_POST["onpage"];

    // Validate and sanitize the input (you may need additional validation)
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Insert data into the 'login' table (assuming your table is named 'login')
    $query = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

    $convertedUsername = ucwords(str_replace('_', ' ', $username));

    if (mysqli_query($conn, $query)) {
        // Data inserted successfully
        // Now, store the converted username in sessionStorage and redirect
        echo '<script>';
        echo '  sessionStorage.setItem("username", "' . $convertedUsername . '");';
        echo '    window.location.href ="/bookingp.php";';
        echo '</script>';
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
