<?php
require_once "../seed/config.php";
require_once "../seed/common.php";

?>

<?php include "templates/header.php"; ?>

    <main>
        <form action="includes/update.inc.php" method="post">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <input type="text" name="check" value="" style="display:none;" />
        <input type="submit" name="submit" value="Update!" class="join form-control" />
        </form>
    </main>

<?php include "templates/footer.php"; ?>