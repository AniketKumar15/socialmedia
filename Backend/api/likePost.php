<?php
require_once('../db/db.php');
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['id'];

// Expecting JSON data from frontend
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
        echo json_encode(['status' => 'liked']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to like']);
    }
}
?>