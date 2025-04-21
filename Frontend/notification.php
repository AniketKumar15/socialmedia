<?php
require_once('../backend/db/db.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['id'];

// Fetch notifications (example for likes & comments)
$stmt = $conn->prepare("SELECT n.*, u.username, u.profile_pic 
        FROM notifications n 
        JOIN userdata u ON n.sender_id = u.id 
        WHERE n.user_id = ? 
        ORDER BY n.created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">
    <link rel="stylesheet" href="./style/notifications.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "./components/navBar.php"; ?>
    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
            <h2>Notifications</h2>
            <div class="notificationsContainer">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="notificationCard">
                        <img src="<?= !empty($row['profile_pic']) ? '../' . $row['profile_pic'] : './img/avatar.png' ?>"
                            alt="Profile">
                        <div>
                            <p><strong>@<?= htmlspecialchars($row['username']) ?></strong>
                                <?= htmlspecialchars($row['action']) ?></p>
                            <small><?= timeAgo($row['created_at']) ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
        <?php include "./components/rightSideBar.php" ?>
    </main>

</body>

</html>