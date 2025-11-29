<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$update_message = "";
$update_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // <- Added

    $sql = "UPDATE Users SET username='$username', email='$email', phone='$phone' WHERE user_id='$user_id'"; // make sure column is user_id
    if ($conn->query($sql) === TRUE) {
        $update_message = "Profile updated!";
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
    } else {
        $update_error = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM Users WHERE user_id='$user_id'"; // make sure column is user_id
$result = $conn->query($sql);
$user = $result->fetch_assoc();


// DELETE ACCOUNT
if (isset($_POST['delete_account'])) {
    $delete_sql = "DELETE FROM Users WHERE user_id='$user_id'";

    if ($conn->query($delete_sql) === TRUE) {
        session_destroy();
        header("Location: ../auth/login.php?deleted=1");
        exit();
    } else {
        $update_error = "Error deleting account: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CityRide</title>
     <link rel="stylesheet" href="../../aboutus.css">
  <link rel="stylesheet" href="../../footer.css">
  <link rel="stylesheet" href="updated.css">
    
</head>
<body>

  <!-- Navbar -->
<div class="navbar">
        <img class="logopic" src="../../images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="../../Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="../../AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the" href="../../Catalogue.php">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="../../Reviews.php">Reviews</a></div>
            <div class="navbtn"><a class="the active" href="../booking/booking.php">Bookings</a></div>
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

<div class="con">
 <div class="profile-container">
        <h2>Your Profile</h2>

        <?php if(isset($update_message)) { echo "<div class='message'>{$update_message}</div>"; } ?>
        <?php if(isset($update_error)) { echo "<div class='message error'>{$update_error}</div>"; } ?>

        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <button type="submit" class="button1">Update Profile</button>

            <button type="submit" name="delete_account" class="delete-btn button1" 
              onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                Delete Account
            </button>

        </form>
        </div>
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
