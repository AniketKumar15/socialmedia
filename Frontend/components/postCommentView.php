<?php
require_once('../../backend/db/db.php');
date_default_timezone_set('Asia/Kolkata');
session_start();

if (!isset($_GET['post_id'])) {
    echo "<p>Invalid post.</p>";
    exit;
}

$post_id = intval($_GET['post_id']);

// Fetch the post
$sql = "SELECT posts.*, userdata.username, userdata.profile_pic 
        FROM posts 
        JOIN userdata ON posts.user_id = userdata.id 
        WHERE posts.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$profilePic = !empty($post['profile_pic']) ? "../" . $post['profile_pic'] : './Img/avatar.png';

if (!$post) {
    echo "<p>Post not found.</p>";
    exit;
}

// Fetch comments
$comments = [];
$commentSql = "SELECT comments.*, userdata.username, userdata.profile_pic 
               FROM comments 
               JOIN userdata ON comments.user_id = userdata.id 
               WHERE post_id = ? 
               ORDER BY comments.created_at DESC";
$commentStmt = $conn->prepare($commentSql);
$commentStmt->bind_param("i", $post_id);
$commentStmt->execute();
$result = $commentStmt->get_result();

while ($row = $result->fetch_assoc()) {
    $comments[] = $row;
}


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
?>

<!-- Post display -->
<div class="post-card">
    <div class="post-header">
        <img src=<?= htmlspecialchars($profilePic) ?> alt="User Avatar" class="avatar" />
        <div>
            <h3>@<?= htmlspecialchars($post['username']) ?></h3>
            <span class="timestamp"><?= timeAgo($post['created_at']) ?></span>
        </div>
    </div>
    <div class="post-content">
        <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>

        <?php if (!empty($post['image_url'])): ?>
            <img src="../<?= htmlspecialchars($post['image_url']) ?>" class="post-media" alt="Post image" />
        <?php endif; ?>

        <?php if (!empty($post['video_url'])): ?>
            <video class="post-media" controls>
                <source src="../<?= htmlspecialchars($post['video_url']) ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        <?php endif; ?>
    </div>
</div>

<!-- Comment Input -->
<form id="commentForm" class="comment-form" style="margin-top: 20px;" method="post">
    <input id="commentText" name="comment" placeholder="Write a comment..." />
    <button type="submit" id="submitComment" data-post-id="<?= $post_id ?>"><i
            class="fa-solid fa-arrow-right"></i></button>
</form>

<!-- Comments List -->
<div class="comments" style="margin-top: 20px;">
    <h4>Comments</h4>
    <?php if (empty($comments)): ?>
        <p>No comments yet. Be the first to comment!</p>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div class="comment" style="border-bottom: 1px solid #ccc; padding: 10px 0;">
                <div class="userInfoComment">
                    <div class="userInfo">
                        <img src=<?= htmlspecialchars(!empty($comment['profile_pic']) ? "../" . $comment['profile_pic'] : './Img/avatar.png') ?> alt="User Avatar" class="avatar" />
                        <strong>@<?= htmlspecialchars($comment['username']) ?>:</strong>
                    </div>
                    <small><?= timeAgo($comment['created_at']) ?></small>
                </div>
                <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>

</script>