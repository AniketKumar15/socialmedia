<?php
session_start();
include "../db/db.php";

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$content = isset($_POST['postText']) ? trim($_POST['postText']) : '';
$image_url = null;
$video_url = null;

// Handle image upload
if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] === 0) {
    $imageName = uniqid('img_') . '_' . basename($_FILES['postImage']['name']);
    $targetImagePath = '../../uploads/images/' . $imageName;
    if (move_uploaded_file($_FILES['postImage']['tmp_name'], $targetImagePath)) {
        $image_url = 'uploads/images/' . $imageName;
    }
}

// Handle video upload
if (isset($_FILES['postVideo']) && $_FILES['postVideo']['error'] === 0) {
    $videoName = uniqid('vid_') . '_' . basename($_FILES['postVideo']['name']);
    $targetVideoPath = '../../uploads/videos/' . $videoName;
    if (move_uploaded_file($_FILES['postVideo']['tmp_name'], $targetVideoPath)) {
        $video_url = 'uploads/videos/' . $videoName;
    }
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO posts (user_id, content, image_url, video_url) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $user_id, $content, $image_url, $video_url);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Post uploaded successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to upload post']);
}
?>