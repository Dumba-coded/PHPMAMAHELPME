<?php

session_start();
require_once 'link.php';

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $checkemail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkemail->num_rows > 0){
        $_SESSION['register_error'] = 'Email is already registered.';
        $_SESSION['active_form'] = 'register';
    } else {
        $conn->query("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    }

    header("Location: link.php");
    exit();

}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password. Please try again.';
    $_SESSION['active_form'] = 'login';
    
    header("Location: link.php");
    exit();

}


?>