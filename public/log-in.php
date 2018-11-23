<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require "../seed/common.php";

session_start();

/**
 * Variables:
 */
$username = $attemptedPassword  = "";
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
            $errors[] = 'No such user.';
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
                $errors[] = 'Invalid username / password combination.';
            }
        }

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php include "templates/general-header.php"; ?>

    <div class="log-in">

        <h2>Log in:</h2>

        <?php
        if(!empty($error)) {
        echo '<h2>Error(s)!<?h2>' . '<br>';
        foreach($errors as $errormessage) {
            echo $errormessage . '<br>';
            }
            }
        ?>

        <form method="post" class="log-in-form">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
            <input type="text" name="username" id="username" placeholder="Username" class="form-control" />
            <input type="text" name="userpassword" id="password" placeholder="Password" class="form-control" />
            <input type="text" name="check" value="" style="display:none;" />
            <input type="submit" name="login" value="Log In" class="log-in-submit form-control" />
        </form>

    </div>

<?php include "templates/footer.php"; ?>