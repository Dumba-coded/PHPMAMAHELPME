<?php
    $servername = "localhost"; // or 127.0.0.1
    $username = "root";
    $password = "";
    $DB = "CityRide_db"; // your new database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $DB);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected!"; // ash check if it works for u and then remove it after testing
?>
