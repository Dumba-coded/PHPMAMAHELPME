<?php
    $servername = "localhost"; 
    $username = "root";
    $password = "";
    $DB = 'reviewpage';

    $conn = new mysqli( $servername, $username, $password,$DB );

    if ($conn->connect_error) {
        die('Connection failed:' .$conn->connect_error);
    }
        else{
    echo "Sucessfully connected.";}

