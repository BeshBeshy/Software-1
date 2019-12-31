<?php

$host = "localhost";
$db_name = "software";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
    $conn->exec("set names utf8");
} catch (PDOException $exception) {
    echo "Connection error: " . $exception->getMessage();
}
