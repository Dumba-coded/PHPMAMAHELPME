<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user info
$userQuery = $conn->prepare("SELECT username, email, phone FROM Users WHERE user_id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

// Get list of available cars
$carsResult = $conn->query("SELECT car_id, vehicle_type, model FROM Cars WHERE available = 1 ORDER BY vehicle_type, model");

$bookingDone = false;
$jsMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $car_id = $_POST['car_id'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    $pickup_location = $_POST['pickup_location'] ?? null;

    $stmt = $conn->prepare("
        INSERT INTO Bookings (user_id, car_id, pickup_date, return_date, pickup_location, status)
        VALUES (?, ?, ?, ?, ?, 'Pending')
    ");
    $stmt->bind_param("iisss", $user_id, $car_id, $pickup_date, $return_date, $pickup_location);

    if ($stmt->execute()) {
        $jsMessage = "Booking confirmed!";
        $bookingDone = true;

        // Optionally mark car as unavailable
        $conn->query("UPDATE Cars SET available = 0 WHERE car_id = $car_id");
    } else {
        $jsMessage = "Error: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book a Vehicle – CityRide</title>

  <link rel="stylesheet" href="../../aboutus.css">
  <link rel="stylesheet" href="../../footer.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f7f7f7;
    }

    .booking-container {
      max-width: 700px;
      margin: 3rem auto;
      background: white;
      padding: 2rem 3rem;
      border-radius: 1rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    h1 { text-align: center; margin-bottom: 1.5rem; }

    label { font-weight: bold; margin-top: 1rem; display: block; }

    input, select, textarea {
      width: 100%;
      padding: .8rem;
      border: 1px solid #ccc;
      border-radius: .5rem;
    }

    textarea { height: 100px; resize: none; }

    .submit-btn {
      width: 100%;
      padding: 1rem;
      background: #ffc928;
      border: none;
      margin-top: 1.5rem;
      font-weight: bold;
      border-radius: .7rem;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
        <img class="logopic" src="../../images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="../../Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="../../AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the" href="../../Catalogue.php">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="../../Reviews.html">Reviews</a></div>
            <div class="navbtn"><a class="the active" href="booking.php">Bookings</a></div>
        </div>     
        <div class="accnt">
            <div class="accnt">
                <div class="login-dropdown">
                    <button class="login-btn">Account ▼</button>
                    <div class="login-menu">
                    <a href="CityRideProject/auth/login.php">Log In/ Sign Up</a>
                    <a href="../auth/update_profile.php">Update Profile</a>
                    <a href="CityRideProject/auth/logout.php">Log Out</a>
                    </div>
                </div>
                </div>
        </div>
  </div>


<div class="booking-container">
    <h1>Book Your Ride</h1>

    <!-- AUTO-FILLED USER INFO -->
    <label>Account Name</label>
    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly>

    <label>Email</label>
    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>

    <label>Phone</label>
    <input type="text" value="<?= htmlspecialchars($user['phone']) ?>" readonly>

    <form method="POST" <?= $bookingDone ? 'onsubmit="return false;"' : '' ?>>
        <label>Choose a Vehicle</label>
<select name="car_id" required>
    <option value="">-- Select Vehicle --</option>
    <?php while($car = $carsResult->fetch_assoc()): ?>
        <option value="<?= $car['car_id'] ?>">
            <?= htmlspecialchars($car['vehicle_type'] . ' - ' . $car['model']) ?>
        </option>
    <?php endwhile; ?>
</select>

        <label>Pickup Date</label>
        <input type="date" name="pickup_date" required>

        <label>Return Date</label>
        <input type="date" name="return_date" required>

        <label>Pickup Location (Optional)</label>
        <input type="text" name="pickup_location">

        <button type="submit" class="submit-btn">Confirm Booking</button>
    </form>
</div>


   <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-left">
        <img src="../../images/rentallogo.png" class="footer-logo" alt="Logo">
        <h3>CityRide</h3>
        <p>Your Go-To Rental Service</p>
      </div>

      <div class="footer-links">
        <h4>Quick Links</h4>
        <a href="Landing.html">Homepage</a>
        <a href="AboutUs.html">About Us</a>
        <a href="Catalogue.html">Vehicles</a>
        <a href="Reviews.html">Reviews</a>
      </div>

      <div class="footer-contact">
        <h4>Contact</h4>
        <p>Email: support@cityride.com</p>
        <p>Phone: +60 12-345 6789</p>
        <p>Address: Kuala Lumpur, Malaysia</p>
      </div>
    </div>

    <div class="footer-bottom">
      © 2025 CityRide — All Rights Reserved
    </div>
  </footer>
  

  <?php if($jsMessage): ?>
<script>
    alert("<?= addslashes($jsMessage) ?>");
</script>
<?php endif; ?>

 <script>
  const loginDropdown = document.querySelector('.login-dropdown');
  const loginBtn = document.querySelector('.login-btn');

  loginBtn.addEventListener('click', () => {
    loginDropdown.classList.toggle('show');
  });

  // Close the dropdown if clicked outside
  window.addEventListener('click', function(e) {
    if (!loginDropdown.contains(e.target)) {
      loginDropdown.classList.remove('show');
    }
  });
</script>

</body>
</html>
