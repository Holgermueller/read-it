<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../seed/config.php";
require "../../seed/common.php";

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