<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require_once "../seed/common.php";

$errors = array();

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
            $errors[] = "You must fill out all of the fields.";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $errors[] = "Username  and email not valid";
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $errors[] = "Username not valid";
        }

        $sql = "SELECT COUNT(username) AS num FROM users WHERE username = :username";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if($row['num'] > 0) {
            $errors[] = 'That username already exists.';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'That is not a valid email address.';
        }

        $sql = "SELECT COUNT(email) AS num FROM users WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if($row['num'] > 0) {
            $errors[] = 'That email already exists.';
        }

        $okedpassword = '';
        if($userpassword !== $confirmpassword){
            $errors[] = 'The passwords must match.';
        } else {
            $okedpassword = $userpassword;
        }

        $passwordHash = password_hash($okedpassword, PASSWORD_BCRYPT, array("cost" => 12));

        $activation_code = bin2hex(openssl_random_pseudo_bytes(16));

         /**
          * Send activation code to user.
          */


        $sql = "INSERT INTO users (firstname, lastname, username, email, activation_code, userpassword) VALUES 
            :firstname, :lastname, :username, :email, :activation_code, :userpassword)";
        $statement = $connection->prepare($sql);

        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':activation_code', $activation_code);
        $statement->bindValue(':userpassword', $passwordHash);

        $result = $statement->execute();

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

    header("Location: activate.php");
    $statement = null;
    $connection = null;
}
?>

<?php include "templates/header.php"; ?>

    <main class="registration-form-background">
        <div class="wrapper">
        <section>
        <h2 class="join-in">Join!</h2>
        <p> Please fill out all the fields below.</p>

        <?php  if(!empty($errors)){
            echo '<h3>Error(s):</h3>'. '<br>';
            foreach($errors as $errormessage){
                echo $errormessage . '<br>';
            }
        };?>
        <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="registration">
            <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstName" placeholder="First name" class="form-control" />
            <input type="text" name="lastname" id="lastName" placeholder="Surname" class="form-control" />
            <input type="text" name="username" id="userName" placeholder="Username" class="form-control" />
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
            <input type="password" name="userpassword" id="userPassword" placeholder="Password" class="form-control" />
            <input type="password" name="confirmpassword" id="confirmPassword" placeholder="Confirm Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="join" value="Join!" class="join form-control" />
            <br>
            </form>
        </section>
        </div>
    </main>

<?php include "templates/footer.php"; ?>
