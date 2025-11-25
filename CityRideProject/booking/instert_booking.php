<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $car_model = mysqli_real_escape_string($conn, $_POST['car_model']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO Booking (user_id, car_model, date, time) 
            VALUES ('$user_id', '$car_model', '$date', '$time')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful! <a href='my_booking.php'>View My Bookings</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
