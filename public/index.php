<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read It!</title>
</head>
<body>

<?php
require "../seed/config.php";

/**
 * Grab infor from registration form
 * and feed it to user database
 */

?>

<?php include "templates/log-in-header.php"; ?>

    <div class="registration-form-background">

        <h2 class="join-in">Join!</h2>

        <form action="post" class="registration">
            <input type="text" placeholder="First name" class="form-control">
            <input type="text" placeholder="Surname" class="form-control">
            <input type="text" placeholder="Email" class="form-control">
            <input type="text" placeholder="Password" class="form-control">
            <input type="text" placeholder="Verify password" class="form-control">
            <input type="submit" value="Join!" class="join form-control">
        </form>

    </div>

<?php include "templates/footer.php"; ?>
    
</body>
</html>