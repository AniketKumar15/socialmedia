<?php
require_once('../backend/db/db.php');
session_start();
date_default_timezone_set('Asia/Kolkata');

if (!isset($_GET['user_id'])) {
    echo "Invalid user.";
    exit;
}

$user_id = intval($_GET['user_id']);
$user_idSession = $_SESSION["id"];

$isFollowing = false;
$isFollowedBack = false;

if ($user_id !== $user_idSession) {
    $stmt = $conn->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt->bind_param("ii", $user_idSession, $user_id);
    $stmt->execute();
    $stmt->store_result();
    $isFollowing = $stmt->num_rows > 0;
    $stmt->close();

    // Check if this profile is following the logged-in user (for "Follow Back")
    $stmt2 = $conn->prepare("SELECT 1 FROM follows WHERE follower_id = ? AND following_id = ?");
    $stmt2->bind_param("ii", $user_id, $user_idSession);
    $stmt2->execute();
    $stmt2->store_result();
    $isFollowedBack = $stmt2->num_rows > 0;
    $stmt2->close();
}

// Fetch user info
$userQuery = $conn->prepare("SELECT fullname, username, email, profile_pic FROM userdata WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

// Fetch user posts
$postQuery = $conn->prepare("SELECT * FROM posts WHERE user_id = ? ORDER BY created_at DESC");
$postQuery->bind_param("i", $user_id);
$postQuery->execute();
$postsResult = $postQuery->get_result();

// Followers count
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM follows WHERE following_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$followerCount = $result['count'];
$stmt->close();
// Following count
$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM follows WHERE follower_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$followingCount = $result['count'];
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($user['username']) ?>'s Profile</title>
    <link rel="stylesheet" href="./style/profile.css">
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/postCardStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php include "./components/navBar.php"; ?>
    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
            <div class="profile-container">
                <div class="profile-header">
                    <img src=<?= htmlspecialchars(!empty($user['profile_pic']) ? "../" . $user['profile_pic'] : './Img/avatar.png') ?> class="profile-avatar" alt="Avatar">
                    <div class="user-info">
                        <h2><?= htmlspecialchars($user['fullname']) ?></h2>
                        <p>@<?= htmlspecialchars($user['username']) ?></p>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                    </div>

                    <?php if ($user_id == $user_idSession): ?>
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
                    <?php while ($post = $postsResult->fetch_assoc()): ?>
                        <div class="post-card">
                            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                            <?php if (!empty($post['image_url'])): ?>
                                <img src="../<?= htmlspecialchars($post['image_url']) ?>" class="post-media">
                            <?php endif; ?>
                            <?php if (!empty($post['video_url'])): ?>
                                <video class="post-media" controls>
                                    <source src="../<?= htmlspecialchars($post['video_url']) ?>" type="video/mp4">
                                </video>
                            <?php endif; ?>
                            <span class="timestamp"><?= $post['created_at'] ?></span>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        </section>

        <?php include "./components/rightSideBar.php" ?>


        <?php include "./components/profileEditModel.php"; ?>

    </main>
    <script src="./js/followers.js"></script>
    <script src="./js/checkNotification.js"></script>
    <script>
        console.log("helloNew")
        document.addEventListener('DOMContentLoaded', async () => {
            const editBtn = document.getElementById('editProfileBtn');
            const modal = document.getElementById('editProfileModal');
            const form = document.getElementById('editProfileForm');
            const previewImage = document.getElementById('previewImage');

            // Open modal and load data
            editBtn.addEventListener('click', async () => {
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