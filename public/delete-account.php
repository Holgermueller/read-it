<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * function to delete a user account
 */


 /**
  * function to return user to his or her profile
  */
if(isset($_POST['nodelete'])) {
  header('Location: profile.php');
}

?>

<?php include "templates/header.php"; ?>

<div class="delete-account">

  <h2>Hello, 'Name goes here'</h2>

  <h2>Are you sure you want to delete your account?</h2>

  <div class="deletion-choices">
    <input type="submit" name="yesdelete" value="Yes" class="yes-no" />
    |
    <input type="submit" name="nodelete" value="No" class="yes-no" />
  </div>

</div>

<?php include "templates/footer.php"; ?>