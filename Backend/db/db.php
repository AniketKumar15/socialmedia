<?php
$server = "localhost";
$username = "root";
$password = "";
$dbName = "socialmedia";

$conn = new mysqli($server, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($conn->query($sql) !== TRUE) {
    die("Error creating database: " . $conn->error);
}
$conn->select_db($dbName);

include "tableCreation.php";


?>