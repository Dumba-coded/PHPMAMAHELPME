<?php
require "../db.php";
session_start();

if (isset($_POST["login"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM Users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];

        header("Location: ../user/profile.php");
        exit();
    } else {
        $_SESSION["error"] = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - CityRide</title>
</head>
<body>

<h2>Login</h2>

<?php 
if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}
?>

<form method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>

    <button type="submit" name="login">Login</button>
</form>

<a href="register.php">Create an account</a>

</body>
</html>
