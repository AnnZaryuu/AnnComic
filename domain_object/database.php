<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "komik";

$db = mysqli_connect($hostname, $username, $password, $database_name);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
} else {
    echo "Connected successfully";
}

?>