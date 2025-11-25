<?php
session_start();
require __DIR__ . '/../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$update_message = "";
$update_error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']); // <- Added

    $sql = "UPDATE Users SET username='$username', email='$email', phone='$phone' WHERE user_id='$user_id'"; // make sure column is user_id
    if ($conn->query($sql) === TRUE) {
        $update_message = "Profile updated!";
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;
    } else {
        $update_error = "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM Users WHERE user_id='$user_id'"; // make sure column is user_id
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - CityRide</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            width: 90%;
            max-width: 30rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
            font-size: 1rem;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #ccc;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #eee200;
            border: none;
            border-radius: 0.5rem;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #d4c300;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>Your Profile</h2>

        <?php if(isset($update_message)) { echo "<div class='message'>{$update_message}</div>"; } ?>
        <?php if(isset($update_error)) { echo "<div class='message error'>{$update_error}</div>"; } ?>

        <form method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>

