<?php
require_once "../seed/config.php";
require_once "../seed/common.php";

?>

<?php include "templates/header.php"; ?>

<div class="delete-account">

  <h2>Hello, 'Name goes here'</h2>

  <h2>Are you sure you want to delete your account?</h2>

  <div class="deletion-choices">
    <form action="includes/delete.inc.php">
    <input type="submit" name="yesdelete" value="Yes" class="yes-no" />
    |
    <input type="submit" name="nodelete" value="No" class="yes-no" />
    </form>
  </div>

</div>

<?php include "templates/footer.php"; ?>