<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Booking WHERE user_id='$user_id'";
$result = $conn->query($sql);

echo "<h2>My Bookings</h2>";
echo "<a href='book.php'>Book Another Car</a><br><br>";

while($row = $result->fetch_assoc()) {
    echo "Car: " . $row['car_model'] . " | Date: " . $row['date'] . " | Time: " . $row['time'];
    echo " <a href='delete_booking.php?id=" . $row['id'] . "'>Delete</a><br>";
}
