<?php
require_once('../db/db.php');
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['post_id']) || !isset($data['content'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    exit;
}

$user_id = $_SESSION['id'];
$post_id = $data['post_id'];
$content = trim($data['content']);
$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

if (empty($content)) {
    echo json_encode(['status' => 'error', 'message' => 'Comment cannot be empty']);
    exit;
}

$sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("iis", $post_id, $user_id, $content);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query error']);
}

?>