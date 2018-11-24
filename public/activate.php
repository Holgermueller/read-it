<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require "../seed/common.php";

/**
 * To check activation code against.
 */
$activation_code_checked = "";

/**
 * For errors.
 */
$errors = array();

if(isset($_POST['submit'])) {

    if (!hash_equals($_SESSION['csrf'], $_POST['csrf']))die();

    try {
        $connection = new PDO($dsn, $pdousername, $password, $options);

    } catch(PDOException $error) {
        echo $sql . "<br>" .$error->getMessage();
    }

    /**
     * Redirect user to profile page.
     */
    header('Location: profile.php');
    $statment = null;
    $connection = null;

}

?>

<?php include "templates/header.php"; ?>

<div class="welcome">
<h1>Welcome to Read It!</h1>
<h2>You're almost there.</h2>
<div class="activation-instructions">Check your email for your activate code.</div>
<form method="post" class="activate-account" action="">
<input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
<input type="text" name="confirmactivationcode" id="confirmActivationCode" placeholder="Enter Activation Code" class="form-control">
<input type="text" name="check" value="" style="display:none;" />
<input type="submit" name="submit" value="Activate!" class="activate form-control">
</form>
</div>

<?php include "templates/footer.php"; ?>