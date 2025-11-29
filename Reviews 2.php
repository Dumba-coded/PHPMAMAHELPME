<?php
session_start();
require __DIR__ . '/CityRideProject/db.php'; // your database connection

// Redirect if not logged in
$user_id = $_SESSION['user_id'] ?? null;

// Handle new review submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $rating = (int)$_POST['rating'];
    $review_text = $_POST['review_text'];

    if ($rating >= 1 && $rating <= 5 && !empty($review_text)) {
        $stmt = $conn->prepare("INSERT INTO Reviews (user_id, rating, review_text) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $rating, $review_text);

        if ($stmt->execute()) {
            $message = "Review submitted successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
    } else {
        $message = "Please enter a valid rating and review text.";
    }
}

// Fetch all reviews
$reviews = $conn->query("
    SELECT r.*, u.username 
    FROM Reviews r
    JOIN Users u ON r.user_id = u.user_id
    ORDER BY r.created_at DESC
")->fetch_all(MYSQLI_ASSOC);

// Calculate average rating
$avg_rating_result = $conn->query("SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM Reviews");
$avg_data = $avg_rating_result->fetch_assoc();
$average_rating = round($avg_data['avg_rating'] ?? 0, 1);
$total_reviews = $avg_data['total_reviews'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide — Your Go-to Car Rental Service!</title>
    <link rel="stylesheet" href="reviewstyle.css">
    <link rel="stylesheet" href="footer.css">
</head>
<body>
     <div class="navbar">
        <img class="logopic" src="images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the" href="Catalogue.php">Vehicles</a></div>
            <div class="navbtn"><a class="the active" href="Reviews.html">Reviews</a></div>
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

        <div class="reviewtop">
            <div class="tp">
                <span class="heading">What Our Users Think</span>
                <span class="totalstars">4.3</span><span class="contd">out of<br>5.0 stars<br><span class="total">(7 total reviews)</span></span>
            </div>
            <div class="btm">
                <div class="review one">
                    <span class="reviewhead">Comfortable Rides!</span> 
                    <span class="reviewpara">“Renting from CityRide was a smooth and enjoyable experience. The booking process was easy, and I received instant confirmation. The car was clean, comfortable, and drove perfectly. Staff were friendly and helpful, making pickup and drop-off simple. I’ll definitely rent from them again!”</span>
                    <div class="ratingstars"> 
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                    </div>
                </div>
                <div class="review two">
                    <span class="reviewhead">Awesome facilities!</span>                    
                    <span class="reviewpara">“CityRide made my car rental stress-free. Their website was easy to use, and the vehicle I chose was in excellent condition. The staff explained everything clearly, and returning the car was hassle-free. Reliable service at a good price!”</span>
                    <div class="ratingstars"> 
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9734;</span>
                    </div>
                </div>
                <div class="review three">                    
                    <span class="reviewhead">Great accessibility!</span> 
                    <span class="reviewpara">“Fantastic experience with CityRide! The car was comfortable and well-maintained, and the pickup process was quick and professional. I felt supported throughout my trip, and I’ll be using them again for future rentals.”</span>
                    <div class="ratingstars"> 
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                        <span class="topstar">&#9733;</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="reviewmiddle">
            <span class="ask">Let us know what you think!</span>

            <?php if ($user_id): ?>
            <form method="POST">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="">-- Select Rating --</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                
            <div class="reviewstars" data-user-review="1" data-average-rating="4.3" name="rating" id="rating" required>
                <div value="1"><span class="star" data-value="1" value="1">&#9734;</span></div>
                <span class="star" data-value="2">&#9734;</span>
                <span class="star" data-value="3">&#9734;</span>
                <span class="star" data-value="4">&#9734;</span>
                <span class="star" data-value="5">&#9734;</span>
            </div>
            <input class="usertext" type="text" name="review_text" rows="4" placeholder="Write your review here..." required id="usertext" placeholder="Write your review here...">
            <button type="submit">Submit Review</button>
        </div>  
        </form>
        <?php else: ?>
            <p>Please <a href="CityRideProject/auth/login.php">login</a> to submit a review.</p>
        <?php endif; ?>
        <?php if($message) echo "<p>$message</p>"; ?>
    </div>


        <div class="reviewmiddle">
        <span class="ask">Let us know what you think!</span>
        
        <?php if ($user_id): ?>
            <form method="POST">
                <label for="rating">Rating:</label>
                <select name="rating" id="rating" required>
                    <option value="">-- Select Rating --</option>
                    <option value="1">1 Star</option>
                    <option value="2">2 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="5">5 Stars</option>
                </select>
                <br>
                <textarea name="review_text" rows="4" placeholder="Write your review here..." required></textarea>
                <br>
                <button type="submit">Submit Review</button>
            </form>
        <?php else: ?>
            <p>Please <a href="CityRideProject/auth/login.php">login</a> to submit a review.</p>
        <?php endif; ?>
        <?php if($message) echo "<p>$message</p>"; ?>
    </div>

    <div class="reviewbottom"></div>




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
        document.addEventListener('DOMContentLoaded', function() {
            const reviewStars = document.querySelectorAll('.reviewstars');
            const storageKey = 'userReviews' /* stores ratings in local storage & only allows a user to review once */

            /* to fill stars based on average total. container argument is the amount of stars given, rating is the average value */
            function totalStars(container, rating){
                const stars = document.querySelectorAll('.star');
                const roundedRating = Math.round(rating); /* rounds to the nearest whole, since stars can only be filled entirely */
                stars.forEach((star, index) => {
                    /* works like a for loop in python; goes through each star in this case */
                    /* if statement below ensures that the right amount of stars is filled. if this if statement isn't used, the stars will always fill as 5.0, even after the rounding, no matter what */
                    if (index < roundedRating) {
                        star.classList.add('filled'); /* filled class in css turns star yellow — this function adds the class if the star is filled */
                        star.innerHTML = '&#9733'; 
                    } else {
                        star.classList.remove('filled'); /* removes filled class if star is not checked */
                        star.innerHTML = '&#9734';
                    }
                }); 

            }

            const finishedRatings = JSON.parse(localStorage.getItem(storageKey)) || {}; /* checks local storage for any saved ratings with storageKey. 
            it becomes empty object {} if there are no saved variables in the local storage */

            for(let container of reviewStars){
                const userReview = container.dataset.userReview;
                const rating = container.dataset.userReview;
                let averageRating = parseFloat(container.dataset.averageRating) || 0; /* default is 0 if there is no average rating */
                
                /* fills stars when page loads */
                totalStars(container, averageRating);
                if (!container.classList.contains('rated')) {
                    const stars = container.querySelectorAll('.star')
                    for(let star of stars){
                        star.addEventListener('click', function() { /* click is placed inside the if statement to make sure it can only be done with 'rated' is NOT added as a class */
                            const value = parseInt(this.dataset.value); /* get value of star that was clicked */

                            totalStars(container, value);

                            finishedRatings[rating] = value;
                            localStorage.setItem(storageKey, JSON.stringify(finishedRatings));

                            container.classList.add('rated'); /* disables after user rates */

                            /* to send the user's rating to the server */
                            fetch('rate.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    userReview: userReview,
                                    rating: value
                                })
                            })

                            .then(response => response.json()) /* fetches response from rate.php */
                            .then(data => {
                                console.log('Server response:', data); /* fetches data to convert into js object */
                                if (data.status === 'success') {
                                    const avgRating = container.nextElementSibling;
                                    avgRating.text.Content = `Average: ${data.newAverage} / 5 (${data.newCount} votes)`;

                                    updateStars(container, data.newAverage);
                                }
                            
                            })

                            .catch(error=> {
                                console.error('Error:', error);
                                container.classList.remove('rated');
                                delete savedRatings[userReview];
                                localStorage.setItem(storageKey, JSON.stringify(savedRatings));
                                updateStars(container, averageRating);
                        });
                    });
                }

            }
            }
        });
</script>


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