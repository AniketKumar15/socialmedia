<?php
require_once('../backend/db/db.php');

$user_id = $_SESSION['id'] ?? null;

if (!$user_id) {
    echo "<p>Please login to see your friends.</p>";
    exit;
}

// Get the list of users that the current user follows
$sql = "SELECT u.id, u.fullname, u.username, u.profile_pic 
        FROM follows f 
        JOIN userdata u ON f.following_id = u.id 
        WHERE f.follower_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<aside class="rightSideBar">
    <h1>Friends</h1>
    <ul class="friendsList">
        <?php while ($row = $result->fetch_assoc()): ?>
            <li class="friendInfo">
                <a href="profile.php?user_id=<?= urlencode($row['id']) ?>" class="friendCardLink">
                    <div class="frienInfoProfile">
                        <img src="<?= !empty($row['profile_pic']) ? '../' . $row['profile_pic'] : './img/avatar.png' ?>"
                            alt="Avatar">
                        <div>
                            <h3><?= htmlspecialchars($row['fullname']) ?></h3>
                            <p>@<?= htmlspecialchars($row['username']) ?></p>
                        </div>
                    </div>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>

</aside>