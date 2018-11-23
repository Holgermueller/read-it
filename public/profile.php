<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../seed/config.php";
require "../seed/common.php";

if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
    header('Location: log-in.php');
    exit;
}

        $connection = new PDO($dsn, $pdousername, $password, $options);
        $sql = $connection->prepare("SELECT * FROM users WHERE username = :username");
        $statement->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR, 30);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

    echo "hello" . $result['username'];

?>

<?php include "templates/header.php"; ?>

<div class="user-profile">
    <h2>Welcome, <?php 
    echo $_SESSION['username']; ?>
    </h2>
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