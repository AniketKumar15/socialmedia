<?php
session_start();
include "../db/db.php";

// Trim inputs to prevent spaces issue
$username = trim($_POST["username"] ?? '');
$password = trim($_POST["password"] ?? '');

// Check empty fields
if (empty($username) || empty($password)) {
    echo "<script>alert('Please fill in all fields.'); window.location.href='../../Frontend/account.php';</script>";
    exit();
}

// ✅ Use Prepared Statement (Prevents SQL Injection)
$stmt = $conn->prepare("SELECT id, username, password FROM userdata WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {

    $row = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $row["password"])) {

        // 🔐 Regenerate session ID (prevents session fixation)
        session_regenerate_id(true);

        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];

        echo "<script>alert('Login successful!'); window.location.href='../../Frontend/index.php';</script>";
        exit();

    } else {
        echo "<script>alert('Incorrect password.'); window.location.href='../../Frontend/account.php';</script>";
        exit();
    }

} else {
    echo "<script>alert('Username not found.'); window.location.href='../../Frontend/account.php';</script>";
    exit();
}

$stmt->close();
$conn->close();
?>