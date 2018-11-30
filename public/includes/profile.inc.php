<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../../seed/config.php";
require_once "../../seed/common.php";
require_once "profile.inc.php";

if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in'])) {
    //header('Location: index.php');
    exit;
}

if(isset($_SESSION['user_id'])){
    $usersData = getUsersData(getId($_SESSION['user_id']));
    echo $usersData['firstname'];
}

?>