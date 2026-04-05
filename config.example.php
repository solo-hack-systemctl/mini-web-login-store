<?php

$host = "localhost";
$user = "your_db_user";
$pass = "your_db_password";
$db = "mini_web";

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
}

?>
