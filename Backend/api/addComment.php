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
$post_id = intval($data['post_id']);
$content = trim($data['content']);
$content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

if (empty($content)) {
    echo json_encode(['status' => 'error', 'message' => 'Comment cannot be empty']);
    exit;
}

// Insert the comment
$sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("iis", $post_id, $user_id, $content);
    if ($stmt->execute()) {
        // Get post owner to send notification
        $ownerQuery = $conn->prepare("SELECT user_id FROM posts WHERE id = ?");
        $ownerQuery->bind_param("i", $post_id);
        $ownerQuery->execute();
        $ownerResult = $ownerQuery->get_result();

        if ($ownerResult && $owner = $ownerResult->fetch_assoc()) {
            $postOwnerId = $owner['user_id'];

            // Only notify if the commenter is not the owner
            if ($postOwnerId != $user_id) {
                $notifQuery = $conn->prepare("INSERT INTO notifications (user_id, sender_id, post_id, type) VALUES (?, ?, ?, 'comment')");
                $notifQuery->bind_param("iii", $postOwnerId, $user_id, $post_id);
                $notifQuery->execute();
                $notifQuery->close();
            }
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Query error']);
}
?>