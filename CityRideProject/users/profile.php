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
    <title>Profile - CityRide</title>
    <link rel="stylesheet" href="../css/profile.css"> <!-- Optional: your own CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background: #fff8e1; /* soft yellow theme */
        }

        .navbar, .footer {
            width: 100%;
            background: #FFD700; /* taxi yellow */
            padding: 1rem;
        }

        .navbar a {
            margin-right: 1rem;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .profile-container {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 0.5rem rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .profile-info p {
            font-size: 1.1rem;
            margin: 0.5rem 0;
        }

        .logout-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 0.3rem;
        }

        .footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <a href="../Landing.html">Homepage</a>
        <a href="../AboutUs.html">About Us</a>
        <a href="../Catalogue.html">Vehicles</a>
        <a href="../Reviews.html">Reviews</a>
        <span style="float:right;"><a href="../auth/logout.php" class="logout-btn">Logout</a></span>
    </div>

    <!-- Profile Content -->
    <div class="profile-container">
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>

        <div class="profile-info">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        © 2025 CityRide — All Rights Reserved
    </div>

</body>
</html>
