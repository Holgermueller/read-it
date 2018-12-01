<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../seed/config.php";
require_once "../../seed/common.php";

if(isset($_POST['submit'])) {

    $errors = array();

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $userpassword = trim($_POST['userpassword']);
            $confirmpassword = trim($_POST['confirmpassword']);

        /**
         * Make sure user fills out 
         * entire registration form.
         */
        if(empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($userpassword) || empty($confirmpassword)) {
            header("Location: ../index.php?error=emptyfields&");
            $errors[] = "You must fill out all of the fields.";
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
            $errors[] = 'That username already exists.';
        }

        /**
         * Make sure email is valid.
         */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'That is not a valid email address.';
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
        }

        /**
         * Have user confirm password.
         */
        $okedpassword = '';
        if($userpassword !== $confirmpassword){
            $errors[] = 'The passwords must match.';
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
        $verifiacation_link = 'https://www.read-it.com/activation/activate.php?code=' . $activation_code;
            $htmlStr = '';
            $htmlStr .= 'Hello, ' . $email . '<br /><br />';
            $htmlStr .= 'Here is your activation code: ' . $activation_code;
            $htmlStr .= 'You are welcome.';
            $htmlStr .= 'Hope you have fun on our site.';
            $subject_line = 'Verification linke | Read-It | Registration';
            $recipient_email = $email;

        $body = $htmlStr;
        
        mail($recipient_email, $subject_line, $body);

        /**
         * Send all user info to database.
         */
        $sql = "INSERT INTO users (firstname, lastname, username, email, activation_code, userpassword) VALUES 
            (:firstname, :lastname, :username, :email, :activation_code, :userpassword)";
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
}
?>