<?php
session_start();
include "../db/db.php";

// Check if user is logged in
if (!isset($_SESSION["id"]) || !isset($_SESSION["username"])) {
    echo "<script>
        alert('Unauthorized access. Please login again.');
        window.location.href='../../Frontend/account.php';
    </script>";
    exit;
}

$userId = $_SESSION["id"];
$sessionUsername = $_SESSION["username"];
$confirmUsername = $_POST["del_Account"] ?? "";

// Check input
if (!$confirmUsername) {
    echo "<script>alert('Please enter your username to confirm deletion.');</script>";
    exit;
}

// Verify username matches logged-in user
if ($confirmUsername !== $sessionUsername) {
    echo "<script>alert('Username does not match. Account deletion cancelled.');
     window.location.href='../../Frontend/setting.php';</script>";
    exit;
}

// Delete user account
$sql = "DELETE FROM userdata WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);

if ($stmt->execute()) {

    // Destroy session after deletion
    session_unset();
    session_destroy();

    echo "<script>
        alert('Your account has been permanently deleted.');
        window.location.href='../../Frontend/account.php';
    </script>";

} else {
    echo "<script>alert('Failed to delete account. Please try again later.');
    </script>";
}

$stmt->close();
$conn->close();
?>