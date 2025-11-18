<?php
    $servername = "localhost"; //or 128.0.0.1
    $username = "root";
    $password = "";
    $DB = 'CityRideUsers';

    $conn = new mysqli($servername, $username, $password, $DB);

    if ($conn->connect_error) {
        die('Connection failed:' .$conn->connect_error);
    }
        else{
    echo "Sucessfully connected.";}
 ?> 