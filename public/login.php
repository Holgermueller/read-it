<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require_once "../seed/common.php";

$loginErrors = array();

if(isset($_POST['login-submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

        $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
        $attemptedPassword = !empty($_POST['userpassword']) ? trim($_POST['userpassword']) : null;

        if(strlen(trim($username)) === 0 ||
        strlen(trim($attemptedPassword)) === 0) {
            $loginErrors[] = "You must fill in both of the fields.";
        }

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
    header('Location: profile.php');
}

?>

<?php include "templates/general-header.php"; ?>

<main class="log-in">
    <h2>Welcome!</h2>
    <h3>Enter your user info below:</h3>

    <?php  if(!empty($loginErrors)){
            echo '<h3>Error(s):</h3>'. '<br>';
            foreach($loginErrors as $loginerrormessage){
                echo $loginerrormessage . '<br>';
            }
        };?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="registration">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION["csrf"]); ?>"/>
        <input type="text" name="username" id="username" placeholder="Username" class="form-control" />
        <input type="password" name="userpassword" id="password" placeholder="Password" class="form-control" />
        <input type="text" name="check" value="" style="display:none;" />
        <button type="submit" name="login-page-submit" class="login-logout">
            Log In! 
        </button>
    </form>

</main>

<?php include "templates/footer.php"; ?>