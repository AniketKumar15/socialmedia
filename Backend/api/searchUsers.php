<?php
require_once('../../backend/db/db.php');

$query = $_GET['query'] ?? '';

if ($query === '') {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, fullname, username, profile_pic FROM userdata 
        WHERE fullname LIKE ? OR username LIKE ? 
        LIMIT 20";

$param = "%" . $query . "%";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $param, $param);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>