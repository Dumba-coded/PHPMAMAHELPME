<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CityRide — Your Go-to Car Rental Service!</title>
    <link rel="stylesheet" href="signupstyle.css">
</head>
<body>
    <div class="formbox active" id="loginform">
        <form action="regischeck.php" method="post">
            <input type="email" name="email" id="email" placeholder="Email" required>
            <input type="password" name="password" id="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
            <span>Don't have an account? Sign up <a href="#" onclick="displayForm('registrationform')">here.</a></span>
        </form>
    </div>
    <div class="formbox" id="registrationform">
        <form action="regischeck.php" method="post">
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