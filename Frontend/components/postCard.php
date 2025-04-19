<?php
require_once('../backend/db/db.php');
date_default_timezone_set('Asia/Kolkata');
$currentUserId = $_SESSION['id'];

// Get posts from DB (newest first)
$sql = "SELECT posts.*, userdata.username, userdata.fullname 
        FROM posts 
        JOIN userdata ON posts.user_id = userdata.id 
        ORDER BY posts.created_at DESC";
$result = $conn->query($sql);

function timeAgo($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $string = [
        'y' => 'year',
        'm' => 'month',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'min',
        's' => 'sec',
    ];

    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}



if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $postId = $row['id'];
        $username = htmlspecialchars($row['username']);
        $content = nl2br(htmlspecialchars($row['content']));
        $imageUrl = $row['image_url'];
        $videoUrl = $row['video_url'];
        $timeAgo = timeAgo($row['created_at']);

        // Check if current user liked this post
        $liked = false;
        $likeCheck = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?");
        $likeCheck->bind_param("ii", $currentUserId, $postId);
        $likeCheck->execute();
        $likeCheck->store_result();
        if ($likeCheck->num_rows > 0) {
            $liked = true;
        }
        $likeCheck->close();
        // Get total like count for the post
        $likeCount = 0;
        $likeCountQuery = $conn->prepare("SELECT COUNT(*) AS count FROM likes WHERE post_id = ?");
        $likeCountQuery->bind_param("i", $postId);
        $likeCountQuery->execute();
        $likeCountResult = $likeCountQuery->get_result();
        if ($likeCountResult && $rowLikes = $likeCountResult->fetch_assoc()) {
            $likeCount = $rowLikes['count'];
        }
        $likeCountQuery->close();
        ?>

        <div class="post-card">
            <div class="post-header">
                <img src="./Img/avatar.png" alt="User Avatar" class="avatar" />
                <div>
                    <h3><a href="profile.php?user=<?= urlencode($username) ?>">@<?= $username ?></a></h3>
                    <span class="timestamp"><?= $timeAgo ?></span>
                </div>
            </div>
            <div class="post-content">
                <p><?= $content ?></p>

                <?php if (!empty($imageUrl)): ?>
                    <img src="../<?= htmlspecialchars($imageUrl) ?>" class="post-media" alt="Post image" />
                <?php endif; ?>

                <?php if (!empty($videoUrl)): ?>
                    <video class="post-media" controls>
                        <source src="../<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>
            <div class="post-actions">
                <span><i class="<?= $liked ? 'fas liked' : 'far' ?> fa-heart likeBtn" id="likeBtn"
                        data-post-id="<?= $row['id'] ?>"></i> <span class="like-count"><?= $likeCount ?></span></span>

                <i class="far fa-comment"></i>
                <i class="fas fa-share"></i>
            </div>
        </div>

        <?php
    }
} else {
    echo "<p>No posts yet.</p>";
}
?>