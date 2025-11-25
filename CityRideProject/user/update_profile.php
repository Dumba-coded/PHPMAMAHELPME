<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE Users SET username='$username', email='$email' WHERE id='$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Profile updated!";
        header("Refresh:1");
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM Users WHERE id='$user_id'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>

<form method="POST">
    Username: <input type="text" name="username" value="<?php echo $user['username']; ?>"><br>
    Email: <input type="email" name="email" value="<?php echo $user['email']; ?>"><br>
    Phone: <input type="text" name="phone" value="<?php echo $user['phone']; ?>"><br>


    <button type="submit">Update</button>
</form>
