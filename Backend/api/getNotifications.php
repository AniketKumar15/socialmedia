<?php
require_once('../../backend/db/db.php');
session_start();

$user_id = $_SESSION['id'];

$stmt = $conn->prepare("SELECT n.*, u.username, u.profile_pic, p.content AS post_content 
    FROM notifications n 
    JOIN userdata u ON n.sender_id = u.id 
    LEFT JOIN posts p ON n.post_id = p.id
    WHERE n.user_id = ? 
    ORDER BY n.created_at DESC");


$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {

    $notifications[] = $row;
}

echo json_encode(['status' => 'success', 'notifications' => $notifications]);
?>