<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "/Users/holgermueller/Coding_projects/read-it/seed/config.php";
require_once "/Users/holgermueller/Coding_projects/read-it/seed/common.php";


if(isset($_POST['join'])) {

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

            $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
            $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
            $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $userpassword = !empty($_POST['userpassword']) ? trim($_POST['userpassword']) : null;
            $confirmpassword = !empty($_POST['confirmpassword']) ? trim($_POST['confirmpassword']) : null;

        if(strlen(trim($firstname)) === 0 || strlen(trim($lastname)) === 0 || 
        strlen(trim($username)) === 0 || strlen(trim($email)) === 0 || strlen(trim($userpassword)) === 0 ||
        strlen(trim($confirmpassword)) === 0) {
            header("Location: ../index.php?emptyfields=firstname=".$firstname."&lastname=".$lastname."&username=".$username."&email=".$email);
            $errors[] = "You must fill out all of the fields.";
            exit();
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../index.php?error=invalidemail=firstname=".$firstname."&lastname=".$lastname);
            $errors[] = "Username  and email not valid";
            exit();
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            header("Location: ../index.php?error=invalidemail=firstname=".$firstname."&lastname=".$lastname."&email=".$email);
            $errors[] = "Username not valid";
            exit();
        }

         /**
          * Does username already exist?
          */
        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0) {
            header("Location: ../index.php?usernamealreadyexists=firstname=".$firstname."&lastname=".$lastname."&email=".$email);
            $errors[] = 'That username already exists.';
            exit();
        }

         /**
          * Make sure email is valid.
          */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?invalidemail=firstname=".$firstname."&lastname=".$lastname."&username=".$username);
            $errors[] = 'That is not a valid email address.';
            exit();
        }

         /**
          * Does email already exist?
          */
        $sql = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0) {
            $errors[] = 'That email already exists.';
            exit();
        }

         /**
          * Have user confirm password.
          */
        $okedpassword = '';
        if($userpassword !== $confirmpassword){
            $errors[] = 'The passwords must match.';
            exit();
        } else {
            $okedpassword = $userpassword;
        }

         /**
          * Hash user's password.
          */
        $passwordHash = password_hash($okedpassword, PASSWORD_BCRYPT, array("cost" => 12));

         /**
          * Generate activation code.
          */
        $activation_code = bin2hex(openssl_random_pseudo_bytes(16));

         /**
          * Send activation code to user.
          */

         /**
          * Send all user info to database.
          */
        $sql = "INSERT INTO users (firstname, lastname, username, email, activation_code, userpassword) VALUES 
            :firstname, :lastname, :username, :email, :activation_code, :userpassword)";
        $statement = $connection->prepare($sql);

         /**
          * Bind values.
          */
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':activation_code', $activation_code);
        $statement->bindValue(':userpassword', $passwordHash);

         /**
          * Execute.
          */
        $result = $statement->execute();

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

     /**
      * redirect user to profile page
      */
    header("Location: ../activate.php");
    $statement = null;
    $connection = null;
} else {
    header("location: ../index.php?=nicetry.");
    $error[] = "That is not allowed!";
    exit();
}
?>