<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 'TRUE');
require_once "../seed/config.php";
require_once "../seed/common.php";

$connection = new PDO($dsn, $pdousername, $password, $options);
$sql = "SELECT * FROM users WHERE id = " . $_SESSION['user_id'];
$statement = $connection->prepare($sql);
$statement->bindValue($_SESSION['user_id'], $id);
$statement->execute();

function getUsersData($id) {
    $dataArray = array();
    while($result = $statement->setFetchMode(PDO::FETCH_ASSOC)) {
        $dataArray['id'] = $result['id'];
        $dataArray['firstname'] = $result['firstname'];
        $dataArray['lastname'] = $result['lastname'];
        $dataArray['username'] = $result['username'];
        $dataArray['email'] = $result['email'];
        $dataArray['location'] = $result['location'];
        $dataArray['bio'] = $result['bio'];
        $dataArray['datejoined'] = $result['datejoined'];
    }
    return $array;
}

function getId($username) {
        while($result = $statement->setFetchMode(PDO::FETCH_ASSOC)) {
            return $result['id'];
    }
}

?>