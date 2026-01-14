<?php
require_once('../backend/db/db.php');
session_start();
date_default_timezone_set('Asia/Kolkata');

if (!isset($_GET['user_id'])) {
    echo "Invalid user.";
    exit;
}

$user_id = intval($_GET['user_id']);
$currentUserId = $_SESSION["id"];

// Fetch user info
$userQuery = $conn->prepare("SELECT fullname, username, email, profile_pic FROM userdata WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();
$userQuery->close();

if (!$user) {
    echo "User not found.";
    exit;
}

// Followers & following
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM follows WHERE following_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$followerCount = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM follows WHERE follower_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$followingCount = $stmt->get_result()->fetch_assoc()['count'];
$stmt->close();

// Check follow status
$isFollowing = false;
$isFollowedBack = false;
if ($user_id !== $currentUserId) {
    $stmt = $conn->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt->bind_param("ii", $currentUserId, $user_id);
    $stmt->execute();
    $stmt->store_result();
    $isFollowing = $stmt->num_rows > 0;
    $stmt->close();

    $stmt2 = $conn->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt2->bind_param("ii", $user_id, $currentUserId);
    $stmt2->execute();
    $stmt2->store_result();
    $isFollowedBack = $stmt2->num_rows > 0;
    $stmt2->close();
}

// Fetch user posts with user info
$postQuery = $conn->prepare("
    SELECT posts.*, userdata.username, userdata.fullname, userdata.profile_pic 
    FROM posts 
    JOIN userdata ON posts.user_id = userdata.id 
    WHERE user_id = ? 
    ORDER BY posts.created_at DESC
");
$postQuery->bind_param("i", $user_id);
$postQuery->execute();
$postsResult = $postQuery->get_result();

// Helper function: time ago
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['username']) ?>'s Profile</title>
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="./style/profile.css">
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/postCardStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include "./components/navBar.php"; ?>
    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
            <div class="profile-container">
                <div class="profile-header">
                    <img src="<?= htmlspecialchars(!empty($user['profile_pic']) ? "../" . $user['profile_pic'] : './Img/avatar.png') ?>"
                        class="profile-avatar" alt="Avatar">
                    <div class="user-info">
                        <h2><?= htmlspecialchars($user['fullname']) ?></h2>
                        <p>@<?= htmlspecialchars($user['username']) ?></p>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>

                    <?php if ($user_id == $currentUserId): ?>
                        <button class="edit-btn" id="editProfileBtn">Edit</button>
                    <?php else: ?>
                        <?php if ($isFollowing): ?>
                            <button id="followBtn" data-user-id="<?= $user_id ?>" class="follow-btn">Following</button>
                        <?php elseif ($isFollowedBack): ?>
                            <button id="followBtn" data-user-id="<?= $user_id ?>" class="follow-btn">Follow Back</button>
                        <?php else: ?>
                            <button id="followBtn" data-user-id="<?= $user_id ?>" class="follow-btn">Follow</button>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="followerCount">
                        <div class="countBox">
                            <span class="count"><?= $followerCount ?></span>
                            <span class="label">Followers</span>
                        </div>
                        <div class="countBox">
                            <span class="count"><?= $followingCount ?></span>
                            <span class="label">Following</span>
                        </div>
                    </div>
                </div>

                <div class="user-posts">
                    <h3>Posts</h3>
                    <hr>

                    <?php if ($postsResult && $postsResult->num_rows > 0): ?>
                        <?php while ($post = $postsResult->fetch_assoc()):
                            $postId = $post['id'];
                            $username = htmlspecialchars($post['username']);
                            $profilePic = !empty($post['profile_pic']) ? "../" . $post['profile_pic'] : './Img/avatar.png';
                            $content = nl2br(htmlspecialchars($post['content']));
                            $imageUrl = $post['image_url'];
                            $videoUrl = $post['video_url'];
                            $timeAgo = timeAgo($post['created_at']);

                            // Check if current user liked this post
                            $liked = false;
                            $likeCheck = $conn->prepare("SELECT 1 FROM likes WHERE user_id = ? AND post_id = ?");
                            $likeCheck->bind_param("ii", $currentUserId, $postId);
                            $likeCheck->execute();
                            $likeCheck->store_result();
                            if ($likeCheck->num_rows > 0)
                                $liked = true;
                            $likeCheck->close();

                            // Total likes
                            $likeCount = 0;
                            $likeCountQuery = $conn->prepare("SELECT COUNT(*) AS count FROM likes WHERE post_id = ?");
                            $likeCountQuery->bind_param("i", $postId);
                            $likeCountQuery->execute();
                            $likeCountResult = $likeCountQuery->get_result();
                            if ($likeCountResult && $rowLikes = $likeCountResult->fetch_assoc())
                                $likeCount = $rowLikes['count'];
                            $likeCountQuery->close();

                            // Total comments
                            $commentCount = 0;
                            $commentCountQuery = $conn->prepare("SELECT COUNT(*) AS count FROM comments WHERE post_id = ?");
                            $commentCountQuery->bind_param("i", $postId);
                            $commentCountQuery->execute();
                            $commentCountResult = $commentCountQuery->get_result();
                            if ($commentCountResult && $rowComments = $commentCountResult->fetch_assoc())
                                $commentCount = $rowComments['count'];
                            $commentCountQuery->close();
                            ?>

                            <div class="post-card">
                                <div class="post-header">
                                    <img src="<?= htmlspecialchars($profilePic) ?>" alt="User Avatar" class="avatar">
                                    <div>
                                        <h3><a
                                                href="profile.php?user_id=<?= urlencode($post['user_id']) ?>">@<?= $username ?></a>
                                        </h3>
                                        <span class="timestamp"><?= $timeAgo ?></span>
                                    </div>
                                </div>

                                <div class="post-content">
                                    <p><?= $content ?></p>

                                    <?php if (!empty($imageUrl)): ?>
                                        <img src="../<?= htmlspecialchars($imageUrl) ?>" class="post-media" alt="Post Image">
                                    <?php endif; ?>

                                    <?php if (!empty($videoUrl)): ?>
                                        <video class="post-media" controls>
                                            <source src="../<?= htmlspecialchars($videoUrl) ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    <?php endif; ?>
                                </div>

                                <div class="post-actions">
                                    <span>
                                        <i class="<?= $liked ? 'fas liked' : 'far' ?> fa-heart likeBtn"
                                            data-post-id="<?= $postId ?>"></i>
                                        <span class="like-count"><?= $likeCount ?></span>
                                    </span>
                                    <span>
                                        <i class="far fa-comment comment-btn" data-post-id="<?= $postId ?>"></i>
                                        <span><?= $commentCount ?></span>
                                    </span>
                                    <i class="fas fa-share"></i>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <p>No posts yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php include "./components/rightSideBar.php"; ?>
        <?php include "./components/profileEditModel.php"; ?>
    </main>

    <script src="./js/followers.js"></script>
    <script src="./js/checkNotification.js"></script>
    <script src="./js/theme.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const editBtn = document.getElementById('editProfileBtn');
            const modal = document.getElementById('editProfileModal');
            const form = document.getElementById('editProfileForm');
            const previewImage = document.getElementById('previewImage');

            // Open modal and load data
            editBtn?.addEventListener('click', async () => {
                modal.style.display = 'block';

                const res = await fetch('http://localhost/socialmedia/backend/api/getProfileData.php', {
                    credentials: 'include'
                });

                const data = await res.json();

                if (data.status === 'success') {
                    document.getElementById('fullname').value = data.user.fullname;
                    document.getElementById('username').value = data.user.username;
                    document.getElementById('email').value = data.user.email;

                    previewImage.src = data.user.profile_pic
                        ? '' + data.user.profile_pic
                        : './Img/avatar.png';
                }
            });

            // Close modal function
            window.closeModal = () => {
                modal.style.display = 'none';
            };

            // Preview selected image
            window.previewProfilePic = (event) => {
                const file = event.target.files[0];
                if (file) {
                    previewImage.src = URL.createObjectURL(file);
                }
            };

            // Submit updated profile data
            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(form);

                const res = await fetch('http://localhost/socialmedia/backend/api/updateProfile.php', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });

                const result = await res.json();

                if (result.status === 'success') {
                    alert('Profile updated successfully!');
                    window.location.reload();
                } else {
                    alert('Failed to update profile');
                }
            });
        });

    </script>
</body>

</html>