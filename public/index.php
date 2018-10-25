<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read It!</title>
</head>
<body>

<?php include "templates/header.php"; ?>

    <h2 class="join-in">Join!</h2>

    <form action="post" class="registration">
        <input type="text" value="First name">
        <input type="text" value="Surname">
        <input type="text" value="Email">
        <input type="text" value="Password">
        <input type="text" value="Verify password">
        <input type="submit" value="Join!" class="join">

    </form>

<?php include "templates/footer.php"; ?>
    
</body>
</html>