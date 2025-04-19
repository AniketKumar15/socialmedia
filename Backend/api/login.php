<?php
session_start();
include "../db/db.php";

$username = $_POST["username"];
$password = $_POST["password"];

if (!$username || !$password) {
    echo "<script>alert('Please fill in all fields.');</script>";
} else {
    $sql = "SELECT * FROM userdata WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $row["id"];
            echo "<script>alert('Login successful!'); window.location.href = '../../Frontend/index.php';</script>";
        } else {
            echo "<script>alert('Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Username not found.');</script>";
    }
    $conn->close();
}

?>