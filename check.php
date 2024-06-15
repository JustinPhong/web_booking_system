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
    $username = mysqli_real_escape_string($conn, $username);

    // Select booking information for the given username using prepared statement
    $query = "SELECT * FROM booking WHERE username = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        // Get the number of rows returned by the query
        $numRows = mysqli_num_rows($result);

        // Check if there are any rows in the result
        if ($numRows > 0) {
            // Loop through each row and print the data
            $counter = 1; // Initialize a counter
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<script>';
                // Set session storage items based on rows
                echo 'sessionStorage.setItem("bnum", "' . $numRows . '");';
                echo 'sessionStorage.setItem("bdate' . $counter . '", "' . $row["date"] . '");';
                echo 'sessionStorage.setItem("btime' . $counter . '", "' . $row["time"] . '");';
                echo 'sessionStorage.setItem("bcourt' . $counter . '", "' . $row["court"] . '");';
                echo 'window.location.href = "/booking.html";';
                echo '</script>';

                $counter++; // Increment the counter for the next iteration
            }
        } else {
            // No rows returned, redirect to booking.html
            header("Location: /booking.html");
            exit();
        }
    } else {
        // Query execution error
        echo "Error executing query: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Close the database connection
mysqli_close($conn);
?>
