<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRIAL</title>
</head>
<body>
    <h1>PHP DB</h1>

    <form action="db2.php" method="post">
    <p>
        <label for="firstName">First Name:</label>
        <input type="text" name="first_name" id="firstName">
    <br>
        <label for="Contact">Contact Number:</label>
        <input type="text" name="Contact" id="Contact">
    <br>
        <label for="S_DATE">Start of Booking: </label>
        <input type="text" name="S_Date" id="S_DATE">
    <br>
        <label for="R_Date">Retutn of Booking: </label>
        <input type="text" name="R_Date" id="R_Date">
    <br>
        <input type="file" name="image" id="profileImage"> 
<!-- Enter License as an imagine if imagie ins't availble enter serial number -->
 
        <input type="submit" name="submit" value="Submit">

    <br>
</p>
    </form>
</body>
</html>

<?php
    session_start();
    require ''; // Add in DB file (a file the create a DB)
?>