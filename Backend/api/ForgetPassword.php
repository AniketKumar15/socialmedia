<?php
session_start();
include "../db/db.php";

if (!isset($_SESSION["id"])) {
    echo "<script>alert('Unauthorized access. Please login again.'); window.location.href='../../Frontend/login.php';</script>";
    exit;
}

$userId = $_SESSION["id"];
$newPassword = $_POST["new_password"] ?? "";

if (!$newPassword) {
    echo "<script>alert('Please enter a new password.');</script>";
    exit;
}

if (strlen($newPassword) < 8) {
    echo "<script>alert('Password must be at least 8 characters long.');</script>";
    exit;
}

// Hash the new password
$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

// Update password
$sql = "UPDATE userdata SET password = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $hashedPassword, $userId);

if ($stmt->execute()) {
    echo "<script>alert('Password updated successfully.'); window.location.href='../../Frontend/index.php';</script>";
} else {
    echo "<script>alert('Something went wrong. Please try again.');</script>";
}

$stmt->close();
$conn->close();
?>