<?php
session_start();

/**
 * Variables:
 */
$username = $attemptedPassword = "";
$errors = array();

/**
 * Get log in info from form and take user to profile page.
 */

if(isset($_POST['login'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $attemptedPassword = !empty($_POST['userpassword']) ? trim($_POST['userpassword']) : null;

        $sql = "SELECT id, username, userpassword FROM users WHERE username = :username";
        $statement = $connection->prepare($sql);

        $statement->bindValue(':username', $username);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if($user === false) {
            $errors[] = "No such user.";
        }

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

    /**
     * redirect user to profile page
     */
    header("Location: activate.php");
    $statement = null;
    $connection = null;
}

?>

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

    <div class="header">
        <div class="brand">
            <h1 class="app-name header-elem">
            <i class="fas fa-book"></i>
                Read It!
            </h1> 

                <?php
                if(!empty($error)) {
                echo '<h2>Error(s)!<?h2>' . '<br>';
                foreach($errors as $errormessage) {
                echo $errormessage . '<br>';
                    }
                }
                ?>

            <form method="post" class="log-in-form header-elem">
            Log-in: 
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
                <label for="password">Password</label>
                <input type="text" name="userpassword" id="password">
                <input type="text" name="check" value="" style="display:none;" />
                <input type="submit" name="login" value="Log In" class="log-in">
            </form>
        </div>
    </div>
    
</body>
</html>