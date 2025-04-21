<?php
session_start();
include "../Backend/db/db.php";

if (!isset($_SESSION["id"])) {
    header("Location: ./account.php");
}
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
    <link rel="stylesheet" href="./Style/postCardStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">
    <link rel="stylesheet" href="./Style/postModelStyle.css">
    <link rel="stylesheet" href="./Style/commentStyle.css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "./components/navBar.php"; ?>

    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
            <?php include "./components/searchUser.php"; ?>
            <?php include "./components/postCard.php" ?>
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