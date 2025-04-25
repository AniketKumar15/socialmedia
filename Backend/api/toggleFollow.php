<?php
require_once('../db/db.php');
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$data = json_decode(file_get_contents('php://input'), true);
$target_id = intval($data['target_id']);

if ($user_id === $target_id) {
    echo json_encode(['status' => 'error', 'message' => 'You cannot follow yourself']);
    exit;
}

// Check if already following
$check = $conn->prepare("SELECT * FROM follows WHERE follower_id = ? AND following_id = ?");
$check->bind_param("ii", $user_id, $target_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    // Unfollow
    $del = $conn->prepare("DELETE FROM follows WHERE follower_id = ? AND following_id = ?");
    $del->bind_param("ii", $user_id, $target_id);
    $del->execute();
    echo json_encode(['status' => 'unfollowed']);
} else {
    // Follow
    $insert = $conn->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)");
    $insert->bind_param("ii", $user_id, $target_id);
    if ($insert->execute()) {
        // Send notification
        $notif = $conn->prepare("INSERT INTO notifications (user_id, sender_id, type) VALUES (?, ?, 'follow')");
        $notif->bind_param("ii", $target_id, $user_id);
        $notif->execute();
        $notif->close();

        echo json_encode(['status' => 'followed']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to follow']);
    }
}
?>