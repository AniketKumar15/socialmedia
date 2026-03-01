<?php
include "../db/db.php";

$fullname = $_POST["fullname"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$cpassword = $_POST["cpassword"];

if (empty($fullname) || empty($username) || empty($email) || empty($password) || empty($cpassword)) {
    echo "<script>alert('Please fill in all fields.'); window.location.href = '../../Frontend/account.php';</script>";
    exit();
}

// Password strength validation
$pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

if (!preg_match($pattern, $password)) {
    echo "<script>alert('Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character.'); window.location.href = '../../Frontend/account.php';</script>";
    exit();
}

// Check username
$sql = "SELECT * FROM userdata WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<script>alert('Username already taken'); window.location.href = '../../Frontend/account.php';</script>";
    exit();
}

// ✅ NEW: Check email
$sql = "SELECT * FROM userdata WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<script>alert('Email already in use'); window.location.href = '../../Frontend/account.php';</script>";
    exit();
}

// Check password match
if ($password != $cpassword) {
    echo "<script>alert('Password and Confirm Password do not match'); window.location.href = '../../Frontend/account.php';</script>";
    exit();
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Insert user
$sql = "INSERT INTO userdata (fullname, username, email, password)
        VALUES ('$fullname', '$username', '$email', '$hashed_password')";
$result = $conn->query($sql);

if ($result) {
    echo "<script>alert('Account Created Successfully'); window.location.href = '../../Frontend/account.php';</script>";
} else {
    echo "<script>alert('Something Went Wrong'); window.location.href = '../../Frontend/account.php';</script>";
}

?>