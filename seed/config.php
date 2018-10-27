<?php

/**
 * For database connection
 */

$host = "127.0.0.1";
$username = "root";
$password = "Kafka#678";
$dbname = "readit";
$dsn = "mysql:host=$host;dbname=$dbname";
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);

?>