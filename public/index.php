<?php
require "../seed/config.php";
require "../seed/common.php";

/**
 * Grab infor from registration form
 * and feed it to user database
 * then take user to profile page
 */

if(isset($_POST['submit'])) {

    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $new_user = array (
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "email" => $_POST['email'],
            "userpassword" => $_POST['userpassword']
        );

        $sql = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "users",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user))
        );

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

    /**
     * redirect user to profile page
     */

    header("Location: profile.php");
}
?>

<?php include "templates/log-in-header.php"; ?>

    <div class="registration-form-background">

        <h2 class="join-in">Join!</h2>

            <?php if (isset($_POST['submit']) && statement) : ?>
        <blockquote><?php echo escape($_POST['firstname']); ?> successfully added! </blockquote>
<?php endif; ?>

        <form method="post" class="registration">
            <input type="text" name="firstname" id="firstname" placeholder="First name" class="form-control">
            <input type="text" name="lastname" id="lastname" placeholder="Surname" class="form-control">
            <input type="text" name="email" id="email" placeholder="Email" class="form-control">
            <input type="text" name="userpassword" id="userpassword" placeholder="Password" class="form-control">
            <input type="submit" name="submit" value="Join!" class="join form-control">
        </form>

    </div>

<?php include "templates/footer.php"; ?>
