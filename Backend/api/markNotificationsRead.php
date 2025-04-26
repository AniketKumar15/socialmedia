<?php
require_once('../../backend/db/db.php');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$update = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
$update->bind_param("i", $user_id);

if ($update->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
