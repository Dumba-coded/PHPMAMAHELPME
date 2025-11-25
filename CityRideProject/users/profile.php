<?php
// Start session and connect to DB
session_start();
require __DIR__ . '/../db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Get user info
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Users WHERE user_id = $user_id"; // Make sure column name is 'user_id'
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up - CityRide</title>
     <link rel="stylesheet" href="../../login.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="../../footer.css">
    <link rel="stylesheet" href="../../aboutus.css">
   
</head>
<body>

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
                    <a href="../auth/login.php">Log In/ Sign Up</a>
                    <a href="update_profile.php">Update Profile</a>
                    <a href="../auth/logout.php">Log Out</a>
                    </div>
                </div>
                </div>
        </div>
  </div>


</body>
</html>

<div class="con">
    <!-- Profile Content -->
   <div class="main-content">
        <!-- Your profile content, forms, etc. -->
        <div class="profile-container">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>
    </div>
</div>


<footer class="footer">
    <div class="footer-content">
        <div class="footer-left">
            <img src="../../images/rentallogo.png" class="footer-logo">
            <h3>CityRide</h3>
            <p>Your Go-To Rental Service</p>
        </div>
        <div class="footer-links">
            <h4>Quick Links</h4>
            <p><a href="../Landing.html">Homepage</a></p>
            <p><a href="../AboutUs.html">About Us</a></p>
            <p><a href="../Catalogue.html">Vehicles</a></p>
            <p><a href="../Reviews.html">Reviews</a></p>
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
