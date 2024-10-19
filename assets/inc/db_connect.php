<?php

$host = "localhost";
$db_name = "accounts";
$user = "admin";
$pass = "";
$dsn = "mysql:host=".$host.";dbname=".$db_name;

try {
    $pdo = new PDO($dsn, $user, $pass);
} catch( PDOException $e){
    die("Connection failed: ". $e->getMessage());
}
