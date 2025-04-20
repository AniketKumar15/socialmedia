<?php
require_once('../../backend/db/db.php');
session_start();

if (!isset($_SESSION['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['id'];
$fullname = $_POST['fullname'] ?? '';
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$profile_pic_path = ''; // Initialize profile_pic_path variable

// If a new image is uploaded
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../../uploads/profile/'; // Folder to store images
    $fileName = uniqid() . '_' . basename($_FILES['profile_pic']['name']);
    $targetFilePath = $uploadDir . $fileName;

    // Check and create the directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Create the directory if it doesn't exist
    }

    // Move uploaded file to the target directory
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
        // Save relative path in the database
        $profile_pic_path = 'uploads/profile/' . $fileName;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload image']);
        exit;
    }
}

// Prepare the SQL query based on whether a new image is uploaded or not
if ($profile_pic_path) {
    $sql = "UPDATE userdata SET fullname = ?, username = ?, email = ?, profile_pic = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $username, $email, $profile_pic_path, $user_id);
} else {
    $sql = "UPDATE userdata SET fullname = ?, username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $username, $email, $user_id);
}

if ($stmt->execute()) {
    // Optionally fetch the updated user data after the update
    $stmt = $conn->prepare("SELECT fullname, username, email, profile_pic FROM userdata WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $updatedUser = $result->fetch_assoc();

    echo json_encode(['status' => 'success', 'user' => $updatedUser]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
}
?>