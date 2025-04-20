<?php
require_once('../../backend/db/db.php');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$stmt = $conn->prepare("SELECT fullname, username, email, profile_pic FROM userdata WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    $user['profile_pic'] = !empty($user['profile_pic']) ? '../' . $user['profile_pic'] : './Img/avatar.png';
    echo json_encode(['status' => 'success', 'user' => $user]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
}
?>