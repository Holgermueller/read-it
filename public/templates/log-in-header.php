<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Read-It!</title>
<!--styles-->
<link rel="stylesheet" href="./css/styles.css">
<link href="https://fonts.googleapis.com/css?family=Charmonman:700" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
<link type="text/plain" rel="author" href="http://read-it/humans.txt">
</head>
<body>

    <?php

    /**
     * Get log in info from form and take user to profile page.
     */

    ?>

    <div class="header">
        <div class="brand">
            <h1 class="app-name header-elem">
            <i class="fas fa-book"></i>
                Read It!
            </h1> 

            <form method="post" class="log-in-form header-elem">
            Log-in: 
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
                <label for="password">Password</label>
                <input type="text" name="password" id="password">
                <input type="submit" name="login" value="Log In" class="log-in">
            </form>

        </div>
    </div>
    
</body>
</html>