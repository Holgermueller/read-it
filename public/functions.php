<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 'TRUE');
require_once "../seed/config.php";

function getUsersData($id) {
    $dataArray = array();
    $query = mysql_query("SELECT * FROM `users` WHERE `id`=" .$id);
    while($row = mysql_fetch_assoc($query)) {
        $dataArray['id'] = $r['id'];
        $dataArray['firstname'] = $r['firstname'];
        $dataArray['lastname'] = $r['lastname'];
        $dataArray['username'] = $r['username'];
        $dataArray['email'] = $r['email'];
        $dataArray['location'] = $r['location'];
        $dataArray['bio'] = $r['bio'];
        $dataArray['datejoined'] = $r['datejoined'];
    }
    return $array;
}

function getId($username) {
    $query =  mysql_query("SELECT `id` FROM `users` WHERE `username`='".$username."'");
        while($row = mysql_fetch_assoc($query)) {
            return $r['id'];
    }
}

?>