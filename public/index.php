<?php
require_once "../seed/config.php";
require "../seed/common.php";

session_start();
$error="";

/**
 * Grab info from registration form
 * and feed it to user database
 * then take user to profile page.
 */

if(isset($_POST['submit'])) {

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $new_user = array (
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "password" => $_POST['password']
        );

    $error=false;

    /**
     * Make sure user fills out 
     * entire registration form.
     */

    foreach($new_user AS $new_user_field) {
        if(empty($_POST[$new_user_field])) {
            $error = 'You need to fill out all of the required fields!';
        }
    }

        /**
         * Hash user's password.
         */

        /**
         * Generate activation code
         */

        /**
         * Does username already exist?
         */

        /**
         * Does email already exist?
         */

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
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

    <span class="error"><?php echo $error; ?></span>

        <form method="post" class="registration">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstname" placeholder="First name" class="form-control">
            <input type="text" name="lastname" id="lastname" placeholder="Surname" class="form-control">
            <input type="text" name="username" id="user-name" placeholder="Username" class="form-control">
            <input type="email" name="email" id="email" placeholder="Email" class="form-control">
            <input type="password" name="password" id="userpassword" placeholder="Password" class="form-control">
            <input type="submit" name="submit" value="Join!" class="join form-control">
        </form>

    </div>

<?php include "templates/footer.php"; ?>
