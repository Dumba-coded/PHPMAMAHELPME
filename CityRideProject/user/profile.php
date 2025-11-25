<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>

<h2>Welcome, <?php echo $user['username']; ?>!</h2>
<p>Email: <?php echo $user['email']; ?></p>
<p><a href="profile_update.php">Edit Profile</a></p>
<p><a href="../auth/logout.php">Logout</a></p>
<p><a href="../booking/book.php">Book a Car</a></p>
<p><a href="../booking/my_booking.php">My Bookings</a></p>
