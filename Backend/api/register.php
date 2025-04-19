<?php
include "../db/db.php";

$fullname = $_POST["fullname"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($cpassword)) {
    echo "<script>alert('Please fill in all fields.');</script>";
} else {
    $sql = "SELECT * FROM userdata WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<script>alert('Username already Taken');</script>";
    } else {
        if ($password != $cpassword) {
            echo "<script>alert('Password and Confirm Password do not match');</script>";
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "INSERT INTO `userdata`(`fullname`, `username`, `email`, `password`) VALUES ('$fullname','$username','$email','$password')";
            $result = $conn->query($sql);
            if ($result) {
                echo "<script>alert('Account Created Succesfully'); window.location.href = '../../Frontend/account.php';</script>";
            } else {
                echo "<script>alert('Somthing Went worng'); window.location.href = '../../Frontend/account.php';</script>";
            }
        }
    }
}

?>