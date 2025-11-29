# PHPMAMAHELPME
First time doing PHP wish me luck &lt;3



$stmt = $conn->prepare("INSERT INTO Users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $password);
$stmt->execute();



$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registered successfully!";
} else {
    echo "Error: " . $conn->error;
}


