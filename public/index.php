<?php
require "../seed/config.php";
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
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $firstname = test_input($_POST["firstname"]);
//     $lastname = test_input($_POST["lastname"]);
//     $username = test_input($_POST["username"]);
//     $email = test_input($_POST["email"]);
//     $password = test_input($_POST["password"]);
// }

/**
 * Grab info from registration form
 * and feed it to user database
 * then take user to profile page.
 */

if(isset($_POST['submit'])) {

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $username, $password, $options);

            $firstname = !empty($_POST['firstname']) ? trim($_POST['firstname']) : null;
            $lastname = !empty($_POST['lastname']) ? trim($_POST['lastname']) : null;
            $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
            $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
            $userpassword = !empty($_POST['userpassword']) ? trim($_POST['userpassword']) : null;


            $error=false;

        /**
         * Make sure user fills out 
         * entire registration form.
         */

        /**
         * Generate activation code
         */

        /**
         * Does username already exist?
         */
        $sql = "SELECT COUNT (username) AS num FROM users WHERE username = :username";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':username', $username);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0) {
            die('That username already exists.');
        }

        /**
         * Does email already exist?
         */
        $sql = "SELECT COUNT (email) AS num FROM users WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':email', $email);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if($row['num'] > 0) {
            die('That email already exists.');
        }

        /**
         * Hash user's password.
         */
        $passwordHash = password_hash($userpassword, PASSWORD_BCRYPT, array("cost" => 12));

        /**
         * Send all user info to database.
         */

        $sql = "INSERT INTO users (firstname, lastname, username, email, :userpassword) VALUES 
            (:firstname, :lastname, :username, :email, :userpassword)";
        $statement = $connection->prepare($sql);

        /**
         * Bind values.
         */
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':userpassword', $userpassword);

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

    <span class="error"><?php echo $error; ?></span>

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
