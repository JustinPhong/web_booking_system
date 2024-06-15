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
    $convertedUsername = ucwords(str_replace('_', ' ', $username));

    // Check if the username already exists
    $checkQuery = "SELECT * FROM login WHERE username = '$convertedUsername'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) == 0) {
        // Username doesn't exist, proceed with the insertion
        // Insert data into the 'login' table
        $insertQuery = "INSERT INTO login (username, password) VALUES ('$convertedUsername', '$password')";

        if (mysqli_query($conn, $insertQuery)) {
            // Data inserted successfully
            // Now, store the converted username in sessionStorage and redirect
            echo '<script>';
            echo '  sessionStorage.setItem("username", "' . $convertedUsername . '");';
            // Redirect to login-now.php with the username parameter
            echo '  window.location.href = "/login-now.php?username=' . urlencode($convertedUsername) . '&date=" + encodeURIComponent(sessionStorage.getItem("clickedDate"))';
            echo '</script>';
        } else {
            echo "Error inserting data: " . mysqli_error($conn);
        }
    } else {
        // Username already exists, proceed to the next page
        echo '<script>';
        echo '  sessionStorage.setItem("username", "' . $convertedUsername . '");';
        // Redirect to login-now.php with the username parameter
        echo '  window.location.href = "/login-now.php?username=' . urlencode($convertedUsername) . '&date=" + encodeURIComponent(sessionStorage.getItem("clickedDate"))';
        echo '</script>';
    }
}

// Close the database connection
mysqli_close($conn);
?>
