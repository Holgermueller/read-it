<?php
require_once "../seed/config.php";
require "../seed/common.php";

session_start();

/**
 * For errors.
 */
$error = array();

/**
 * Variables for handling form data.
 */
$firstname = $lastname = $username = $email = $userpassword = "";

/**
 * Grab info from registration form
 * and feed it to user database
 * then take user to profile page.
 */

if(isset($_POST['submit'])) {

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

            $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
            $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
            $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $userpassword = !empty($_POST['userpassword']) ? trim($_POST['userpassword']) : null;

        /**
         * Make sure user fills out 
         * entire registration form.
         */
        if(strlen(trim($firstname)) === 0) {
            $error[] = "You must provide your first name.";
        }

        if(strlen(trim($lastname)) === 0) {
            $error[] = "You must provide your last name.";
        }

        if(strlen(trim($username)) === 0) {
            $error[] = "You must provide a username.";
        }

        if(strlen(trim($email)) === 0) {
            $error[] = "You must provide an email.";
        }

        if(strlen(trim($userpassword)) === 0) {
            $error[] = "You must provide a password.";
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
            $error[] = 'That username already exists.';
        }

        /**
         * Make sure email is valid.
         */
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = 'That is not a valid email address.';
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
            $error[] = 'That email already exists.';
        }

        /**
         * Hash user's password.
         */
        $passwordHash = password_hash($userpassword, PASSWORD_BCRYPT, array("cost" => 12));

        /**
         * Generate activation code
         */


        /**
         * Send all user info to database.
         */

        $sql = "INSERT INTO users (firstname, lastname, username, email, userpassword) VALUES 
            (:firstname, :lastname, :username, :email, :userpassword)";
        $statement = $connection->prepare($sql);

        /**
         * Bind values.
         */
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':userpassword', $passwordHash);

        /**
         * Execute.
         */
        $result = $statement->execute();

    } catch(PDOException $error) {
        die($sql . "<br>" . $error->getMessage());
    }

    /**
     * redirect user to profile page
     */
    header("Location: profile.php");
    $statement = null;
    $connection = null;
}
?>

<?php include "templates/log-in-header.php"; ?>

    <div class="registration-form-background">

        <h2 class="join-in">Join!</h2>
        <p> Please fill out the fields below.</p>

            <?php if (isset($_POST['submit']) && statement) : ?>
        <blockquote><?php echo escape($_POST['firstname']); ?> successfully added! </blockquote>
<?php endif; ?>

    <?php
    if(!empty($error)) {
        echo '<h2>Error(s)!<?h2>';
        foreach($error as $errormessage) {
            echo $errormessage . '<br>';
        }
    }
    ?>

        <form method="post" class="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstname" placeholder="First name" class="form-control" />
            <input type="text" name="lastname" id="lastname" placeholder="Surname" class="form-control" />
            <input type="text" name="username" id="user-name" placeholder="Username" class="form-control" />
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
            <input type="password" name="userpassword" id="userpassword" placeholder="Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="submit" value="Join!" class="join form-control" />
        </form>

    </div>

<?php include "templates/footer.php"; ?>
