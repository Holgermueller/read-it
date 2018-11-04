<?php
require_once "../seed/config.php";
require "../seed/common.php";

session_start();

/**
 * For errors.
 */
$error="";

/**
 * Variables for handling form data.
 */
$firstname = $lastname = $username = $email = $password = "";

/**
 * Test data from form.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = test_input($_POST["firstname"]);
    $lastname = test_input($_POST["lastname"]);
    $username = test_input($_POST["username"]);
    $email = test_input($_POST["email"]);
    $password = test_input($_POST["password"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

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
    foreach($_POST AS $new_user_field) {
        if(trim($new_user_field) == "" || empty($_POST[$new_user_field])) {
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

        <form method="post" class="registration" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="firstname" id="firstname" placeholder="First name" class="form-control" />
            <input type="text" name="lastname" id="lastname" placeholder="Surname" class="form-control" />
            <input type="text" name="username" id="user-name" placeholder="Username" class="form-control" />
            <input type="email" name="email" id="email" placeholder="Email" class="form-control" />
            <input type="password" name="password" id="userpassword" placeholder="Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="submit" value="Join!" class="join form-control" />
        </form>

    </div>

<?php include "templates/footer.php"; ?>
