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



btw idk if u also have ot make a bd for it in phpmyadmin or smth but if u do just make a new database named CityRide_db

just paste this in ur MySQL
is should be ughhhh mysql or utf8_general_ci it default for me if it isn't for u then yep

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE Bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    vehicle_type VARCHAR(100) NOT NULL,
    pickup_date DATE NOT NULL,
    return_date DATE NOT NULL,
    pickup_location VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);
