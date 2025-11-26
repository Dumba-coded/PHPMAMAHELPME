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
    <title>CityRide Reviews</title>
    <link rel="stylesheet" href="reviewstyle.css">
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
            <div class="login"><a href="login.html">Log In / Sign Up</a></div>
            <div class="login"><img class="pfp" src="images/emptypfp.png"></div>
        </div>
    </div>
       <div class="reviewtop">
        <div class="tp">
            <span class="heading">What Our Users Think</span>
            <span class="totalstars"><?= $average_rating ?></span>
            <span class="contd">out of<br>5.0 stars<br><span class="total">(<?= $total_reviews ?> total reviews)</span></span>
        </div>
        <div class="btm">
            <?php foreach ($reviews as $r): ?>
                <div class="review">
                    <span class="reviewhead"><?= htmlspecialchars($r['username']) ?></span>
                    <span class="reviewpara"><?= htmlspecialchars($r['review_text']) ?></span>
                    <div class="ratingstars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <span class="topstar"><?= $i <= $r['rating'] ? '&#9733;' : '&#9734;' ?></span>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>
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
                <br>
                <textarea name="review_text" rows="4" placeholder="Write your review here..." required></textarea>
                <br>
                <button type="submit">Submit Review</button>
            </form>
        <?php else: ?>
            <p>Please <a href="login.php">login</a> to submit a review.</p>
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
                            })
                        });
                    }
                }

            }
        });
</script>
</body>
</html>
</div>
