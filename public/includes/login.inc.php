<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../seed/config.php";
require_once "../../seed/common.php";

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