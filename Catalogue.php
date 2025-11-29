<?php
require __DIR__ . '/CityRideProject/db.php';

// Handle sorting/filtering
$sort = $_GET['sort'] ?? 'asc'; // default ascending
$order = ($sort === 'desc') ? 'DESC' : 'ASC';

// Fetch Cars from DB
$result = $conn->query("SELECT * FROM Cars ORDER BY price_per_day $order");
$Cars = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide — Your Go-to Car Rental Service!</title>
    <link rel="stylesheet" href="catalogue.css">
    <link rel="stylesheet" href="Catalogue2.css">
 
</head>
<body>

      <div class="navbar">
        <img class="logopic" src="images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the active" href="Catalogue.html">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="Reviews.php">Reviews</a></div>
            <div class="navbtn"><a class="the" href="CityRideProject/booking/booking.php">Bookings</a></div>
        </div>     
        <div class="accnt">
            <div class="accnt">
                <div class="login-dropdown">
                    <button class="login-btn">Account ▼</button>
                    <div class="login-menu">
                    <a href="CityRideProject/auth/login.php">Log In/ Sign Up</a>
                    <a href="CityRideProject/Users/update_profile.php">Update Profile</a>
                    <a href="CityRideProject/auth/logout.php">Log Out</a>
                    </div>
                </div>
                </div>
        </div>
  </div>

    <span class="heading">Vehicles Available for Rent</span>
   
    <div class="con">
            <div class="filter">
                <form method="GET">
                    <label>Sort by:</label>
                    <select name="sort" onchange="this.form.submit()">
                        <option value="asc" <?= $sort === 'asc' ? 'selected' : '' ?>>Lowest to Highest</option>
                        <option value="desc" <?= $sort === 'desc' ? 'selected' : '' ?>>Highest to Lowest</option>
                    </select>
                </form>
            </div>
        </div>
            </div>
        
<div class="grid">
    <?php foreach ($Cars as $car): ?>
        <div class="card">
            <img src="<?= htmlspecialchars($car['car_image']) ?>" alt="<?= htmlspecialchars($car['car_name']) ?>">
            <h3><?= htmlspecialchars($car['car_name']) ?></h3>
            <p><?= htmlspecialchars($car['description']) ?></p>
            <div class="price">RM <?= number_format($car['price_per_day'], 2) ?> / day</div>
        </div>
    <?php endforeach; ?>
</div>

            </div>
        </div>
    </div>

    <!-- Footer -->
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-left">
        <img src="images/rentallogo.png" class="footer-logo" alt="Logo">
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

<script>
    function filterContent() {
    let user = document.getElementById("filter").value;
    let cars = document.getElementById("cars");
    let vans = document.getElementById("vans");
    let trucks = document.getElementById("trucks");
    let motorbikes = document.getElementById("motorbikes");
    if(user=="A") {
        cars.style.display="block";
        vans.style.display="none";
        trucks.style.display="none";
        motorbikes.style.display="none";
        other.style.display="none";
    } else if (user=="B") {
        cars.style.display="none";
        vans.style.display="block";
        trucks.style.display="none";
        motorbikes.style.display="none";
        other.style.display="none";
    } else if (user=="C") {
        cars.style.display="none";
        vans.style.display="none";
        trucks.style.display="block";
        motorbikes.style.display="none";
        other.style.display="none";
    }
    else if (user=="D") {
        cars.style.display="none";
        vans.style.display="none";
        trucks.style.display="none";
        motorbikes.style.display="block";
        other.style.display="none";
    }
}
</script>
</body>
</html>