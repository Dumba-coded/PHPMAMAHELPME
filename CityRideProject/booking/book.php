<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<h2>Book a Car</h2>
<form method="POST" action="insert_booking.php">
    Car Model: <input type="text" name="car_model" required><br>
    Date: <input type="date" name="date" required><br>
    Time: <input type="time" name="time" required><br>
    <button type="submit">Book</button>
</form>
