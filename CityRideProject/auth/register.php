<?php
require __DIR__ . '/../db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // NEW
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (username, email, phone, password) 
            VALUES ('$username', '$email', '$phone', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registered successfully! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<form method="POST">
    Username: <input type="text" name="username" required><br>
    Email:    <input type="email" name="email" required><br>
    Phone:    <input type="text" name="phone" required><br> <!-- NEW -->
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
