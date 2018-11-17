<?php
require_once "../seed/config.php";
require "../seed/common.php";

session_start();

if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
    header('Location: log-in.php');
    exit;
}

echo "You are logged in!";

?>

<?php include "templates/header.php"; ?>

<div class="user-profile">
    <h2>Welcome 'name goes here'</h2>
    <p>What have you been reading lately?</p>


    <div class="update-links">
    <a href="update-profile.php">Edit Acct.</a>
    |
    <a href="delete-account.php">Delete Acct.</a>
    </div>
</div>

<div class="book-list">
    <h3 class="reading-list">
        My Books!
    </h3>
    <ul>
        <li>
            Books will go here!
        </li>
    </ul>
</div>

<?php include "templates/footer.php"; ?>