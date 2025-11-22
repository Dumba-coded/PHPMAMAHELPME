<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeform = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='errormessage'>$error</p>" : '';
}

function isActiveForm($formname, $activeform) {
    return $formname === $activeform ? 'active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide — Your Go-to Car Rental Service!</title>
    <link rel="stylesheet" href="signupstyle.css">
</head>
<body>
    <div class="navbar">
        <img class="logopic" src="images/rentallogo.png"><span class="logo">CityRide</span><span class="logocapt">Your Go-To Rental Service</span>
        <div class="barbtns">
            <div class="navbtn"><a class="the" href="Landing.html">Homepage</a></div>
            <div class="navbtn"><a class="the" href="AboutUs.html">About Us</a></div>
            <div class="navbtn"><a class="the" href="Catalogue.html">Vehicles</a></div>
            <div class="navbtn"><a class="the" href="Reviews.html">Reviews</a></div>
        </div>   
        <div class="accnt">
            <div class="login active">Log In / Sign Up</div>
            <div class="login"></div>
        </div>
    </div>
    <div class="formbox <?= isActiveForm('login', $activeform); ?>" id="loginform">
        <form action="regischeck.php" method="post">
            <?= showError($errors['login']); ?> <!-- displays error messages, if any, within the session -->
            <input type="text" name="name" id="name" placeholder="Name" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <span>Don't have an account? Sign up <a href="#" onclick="displayForm('registrationform')">here.</a></span>
        </form>
    </div>
    <div class="formbox <?= isActiveForm('register', $activeform); ?>" id="registrationform">
        <form action="regischeck.php" method="post">
            <?= showError($errors['register']); ?> <!-- same thing for errors, just the registration errors instead -->
            <input type="text" name="name" id="name" placeholder="Name" required>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="register">Sign Up</button>
            <span>Already have an account? Log in <a href="#" onclick="displayForm('loginform')">here.</a></span>
        </form>
    </div>

<script>
    function displayForm(formID){
        document.querySelectorAll(".formbox").forEach(form => form.classList.remove("active"));
        document.getElementById(formID).classList.add("active");
    }
</script>
</body>
</html>