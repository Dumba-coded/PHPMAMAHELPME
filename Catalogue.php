<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide — Your Go-to Car Rental Service!</title>
    <link rel="stylesheet" href="catalogue.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>

      <div class="navbar">
        <img class="logopic" src="images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the active" href="Catalogue.html">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="Reviews.html">Reviews</a></div>
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
    <div class="middle">
        <div class="middleright">
            <span class="filterhead">Sort by:</span><br>
            <select id="filter" class="filter" onchange="filterContent();">
                <option value="A">🚘 Cars</option>
                <option value="B">🚐 Vans</option>
                <option value="C">🚛 Trucks</option>
                <option value="D">🛵 Motorbikes</option>
                <option value="E">🚜 Other Vehicles</option>
            </select>
        </div>
        <div class="middleleft">
            <div id="cars">
                CARS
            </div>
            <div id="vans">
                VANS
            </div>
            <div id="trucks">
                TRUCKS
            </div>
            <div id="motorbikes">
                motorbikes
            </div>
            <div id="other">
                other vehicles
            </div>
        </div>
    </div>

</body>



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
    let other = document.getElementById("other");
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
    else if (user=="E") {
        cars.style.display="none";
        vans.style.display="none";
        trucks.style.display="none";
        motorbikes.style.display="none";
        other.style.display="block";
    }
}
</script>
</html>