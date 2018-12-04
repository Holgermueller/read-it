<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require_once "../seed/common.php";

/**
 * Variables:
 */
$username = $attemptedPassword  = "";
$loginErrors = array();

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
            $loginErrors[] = 'No such user.';
        } else {
            $passwordIsValid = password_verify($attemptedPassword, $user['userpassword']);

            if($passwordIsValid) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['logged_in'] = time();

                /**
                 * redirect user to profile page
                 */
                header("Location: profile.php");
                exit;
                
            } else {
                /**
                 * Alert user of error.
                 */
                $loginErrors[] = 'Invalid username / password combination.';
            }
        }

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
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

<header class="header">
    <div class="brand welcome-header">
        <a href="">
        <h1 class="app-name header-elem">
        <i class="fas fa-book"></i>
            Read It!
        </h1>
        </a>
</div>

        <div class="login-logout-forms">

            <?php
            if (!isset($_SESSION['user_id'])) {
                echo '<a href="login.php">
                <button type="submit" name="login-submit" class="login-logout">
                        Log In! 
                        </button>
                </a>';
            } else {
                echo '
                <button type="submit" name="logout-submit" class="login-logout">
                    Log out
                </button>';
            }

            ?>
        </div>

</header>
    
</body>
</html>