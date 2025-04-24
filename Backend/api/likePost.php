<?php
require_once('../db/db.php');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['id'];

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['post_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Post ID missing']);
    exit;
}

$post_id = intval($data['post_id']);

// Check if already liked
$stmt = $conn->prepare("SELECT id FROM likes WHERE user_id = ? AND post_id = ?");
$stmt->bind_param("ii", $user_id, $post_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Already liked → unlike it
    $delete = $conn->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
    $delete->bind_param("ii", $user_id, $post_id);
    if ($delete->execute()) {
        echo json_encode(['status' => 'unliked']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to unlike']);
    }
} else {
    // Not liked yet → insert like
    $insert = $conn->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
    $insert->bind_param("ii", $user_id, $post_id);
    if ($insert->execute()) {
        // Get post owner to notify
        $ownerQuery = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
        $ownerQuery->bind_param("i", $post_id);
        $ownerQuery->execute();
        $ownerResult = $ownerQuery->get_result();
        if ($ownerResult && $row = $ownerResult->fetch_assoc()) {
            $postOwnerId = $row['user_id'];

            // Don't send notification to self
            if ($postOwnerId != $user_id) {
                $notify = $conn->prepare("INSERT INTO notifications (user_id, sender_id, post_id, type) VALUES (?, ?, ?, 'like')");
                $notify->bind_param("iii", $postOwnerId, $user_id, $post_id);
                $notify->execute();
            }
        }

        echo json_encode(['status' => 'liked']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to like']);
    }
}
?>