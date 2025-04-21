<?php
session_start();
include "../Backend/db/db.php";

if (!isset($_SESSION["id"])) {
    header("Location: ./account.php");
}
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenkai - Home</title>
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">




    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "./components/navBar.php"; ?>

    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
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
        </section>
        <section class="commentArea" style="display: none;">

        </section>

        <?php include "./components/rightSideBar.php" ?>
        <label class="add-post-wrapper">
            <button class="add-post-btn" title="Add New Post">
                <i class="fas fa-plus"></i>
            </button>
        </label>

    </main>

    <?php include "./components/postModel.php" ?>

    <script src="./js/uploadPost.js"></script>
    <script src="./js/main.js"></script>
</body>

</html>