<?php
// This canvas will include multiple PHP files separated by comments.
// You can scroll and copy each file individually.

// ==========================
// dp.php
// ==========================
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$DB = "CityRide_db";
$conn = new mysqli($servername, $username, $password, $DB);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
?>

<?php
// ==========================
// register.php
// ==========================
?>
<?php include("dp.php"); ?>
<?php
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name,email,password) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $pass);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Registration failed.";
    }
}
?>
<form method="POST">
    <input name="name" placeholder="Full Name" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="register">Register</button>
</form>

<?php
// ==========================
// login.php
// ==========================
?>
<?php include("dp.php"); session_start(); ?>
<?php
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header("Location: dashboard.php");
            exit();
        }
    }
    echo "Invalid login.";
}
?>
<form method="POST">
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button name="login">Login</button>
</form>

<?php
// ==========================
// logout.php
// ==========================
?>
<?php
session_start(); session_destroy();
header("Location: login.php");
?>

<?php
// ==========================
// dashboard.php
// ==========================
?>
<?php include("dp.php"); session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
?>
<h1>Welcome, <?php echo $_SESSION['user_name']; ?>!</h1>
<a href="book.php">Book a Ride</a>
<a href="view_bookings.php">My Bookings</a>
<a href="edit_profile.php">Edit Profile</a>
<a href="logout.php">Logout</a>

<?php
// ==========================
// edit_profile.php
// ==========================
?>
<?php include("dp.php"); session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$id = $_SESSION['user_id'];

if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $sql = "UPDATE users SET name=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();
    $_SESSION['user_name'] = $name;
    header("Location: dashboard.php");
}

$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>
<form method="POST">
    <input name="name" value="<?php echo $user['name']; ?>" required>
    <input name="email" value="<?php echo $user['email']; ?>" required>
    <button name="save">Save Changes</button>
</form>

<?php
// ==========================
// book.php
// ==========================
?>
<?php include("dp.php"); session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

if (isset($_POST['book'])) {
    $uid = $_SESSION['user_id'];
    $pickup = $_POST['pickup'];
    $dropoff = $_POST['dropoff'];
    $time = $_POST['time'];

    $sql = "INSERT INTO bookings (user_id,pickup,dropoff,time) VALUES (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $uid, $pickup, $dropoff, $time);
    $stmt->execute();
    header("Location: view_bookings.php");
}
?>
<form method="POST">
    <input name="pickup" placeholder="Pickup Location" required>
    <input name="dropoff" placeholder="Dropoff Location" required>
    <input name="time" type="datetime-local" required>
    <button name="book">Book Ride</button>
</form>

<?php
// ==========================
// view_bookings.php
// ==========================
?>
<?php include("dp.php"); session_start();
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$uid = $_SESSION['user_id'];
$rows = $conn->query("SELECT * FROM bookings WHERE user_id=$uid");
?>
<h2>My Bookings</h2>
<?php while ($b = $rows->fetch_assoc()) { ?>
<div>
    <p><b>Pickup:</b> <?php echo $b['pickup']; ?></p>
    <p><b>Dropoff:</b> <?php echo $b['dropoff']; ?></p>
    <p><b>Time:</b> <?php echo $b['time']; ?></p>
</div>
<?php } ?>

<?php
// ==========================
// SQL TABLE CREATION (run in phpMyAdmin)
// ==========================
?>
-- CREATE DATABASE CityRide_db;
-- USE CityRide_db;

-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255)
);

-- BOOKINGS TABLE
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    pickup VARCHAR(255),
    dropoff VARCHAR(255),
    time DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
