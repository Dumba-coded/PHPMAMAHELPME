<?php
session_start();
require __DIR__ . '/../db.php'; // make sure path matches your folder

// LOGIN HANDLER
$login_error = "";
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['email'] = $row['email'];

            header("Location: ../users/profile.php");
            exit();
        } else {
            $login_error = "Wrong password!";
        }
    } else {
        $login_error = "Email not found!";
    }
}

// SIGNUP HANDLER
$signup_error = "";
if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check_sql = "SELECT * FROM Users WHERE email='$email'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $signup_error = "Email already exists!";
    } else {
        $insert_sql = "INSERT INTO Users (username, email, phone, password) VALUES ('$username','$email','$phone','$password')";
        if ($conn->query($insert_sql)) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;

            header("Location: ../users/profile.php");
            exit();
        } else {
            $signup_error = "Error creating account: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Sign Up - CityRide</title>
    <link rel="stylesheet" href="../../loginin.css">
    <link rel="stylesheet" href="../../footer.css">

</head>
<body>
<div class="navbar">
        <img class="logopic" src="../../images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="../../Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the " href="../../AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the" href="../../Catalogue.php">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="../../Reviews.php">Reviews</a></div>
            <div class="navbtn"><a class="the" href="../booking/booking.php">Bookings</a></div>
        </div>     
        <div class="accnt">
            <div class="accnt">
                <div class="login-dropdown">
                    <button class="login-btn">Account ▼</button>
                    <div class="login-menu">
                    <a href="login.php">Log In/ Sign Up</a>
                    <a href="../users/update_profile.php">Update Profile</a>
                    <a href="logout.php">Log Out</a>
                    </div>
                </div>
                </div>
        </div>
  </div>






<div class="con">
    <div class="container">
    
            <div class="wrapper">
                <div class="card-switch">
                    <label class="switch">
                        <input type="checkbox" class="toggle">
                        <span class="slider"></span>
                        <span class="card-side"></span>

                        <div class="flip-card__inner">
                            <!-- LOGIN -->
                            <div class="flip-card__front">
                                <div class="title">Log in</div>
                                <?php if($login_error) { echo "<p style='color:red'>$login_error</p>"; } ?>
                                <form class="flip-card__form" method="POST">
                                    <input class="flip-card__input" name="email" placeholder="Email" type="email" required>
                                    <input class="flip-card__input" name="password" placeholder="Password" type="password" required>
                                    <button class="flip-card__btn" name="login">Let`s go!</button>
                                </form>
                            </div>

                            <!-- SIGNUP -->
                            <div class="flip-card__back">
                                <div class="title">Sign up</div>
                                <?php if($signup_error) { echo "<p style='color:red'>$signup_error</p>"; } ?>
                                <form class="flip-card__form" method="POST">
                                    <input class="flip-card__input" name="username" placeholder="Name" type="text" required>
                                    <input class="flip-card__input" name="email" placeholder="Email" type="email" required>
                                    <input class="flip-card__input" name="phone" placeholder="Phone" type="text" required>
                                    <input class="flip-card__input" name="password" placeholder="Password" type="password" required>
                                    <button class="flip-card__btn" name="signup">Confirm!</button>
                                </form>
                            </div>
                        </div>

                    </label>
                </div>
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
