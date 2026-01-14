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
    <title>Zenkai - About</title>
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/postCardStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">
    <link rel="stylesheet" href="./Style/postModelStyle.css">
    <link rel="stylesheet" href="./Style/commentStyle.css">
    <link rel="stylesheet" href="./Style/aboutPageStyle.css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "./components/navBar.php"; ?>

    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea aboutPage">

            <div class="aboutCard">
                <h1>About Zenkai</h1>
                <p class="aboutIntro">
                    Zenkai is a modern social media platform built to help people connect,
                    share moments, and grow together in a clean, distraction-free environment.
                </p>
            </div>

            <div class="aboutCard">
                <h2>🚀 What is Zenkai?</h2>
                <p>
                    Zenkai focuses on meaningful interactions instead of noise.
                    Whether you're sharing thoughts, images, or moments with friends,
                    Zenkai keeps things simple, fast, and personal.
                </p>
            </div>

            <div class="aboutCard">
                <h2>✨ Core Features</h2>
                <ul class="aboutFeatures">
                    <li>
                        <i class="fa-solid fa-user"></i>
                        <span><strong>User Profiles</strong> — Customize your digital identity</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-pen"></i>
                        <span><strong>Posts</strong> — Share text, images, and videos</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-comments"></i>
                        <span><strong>Comments</strong> — Engage in real conversations</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-bell"></i>
                        <span><strong>Notifications</strong> — Never miss an interaction</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-users"></i>
                        <span><strong>Friends</strong> — Build your personal network</span>
                    </li>
                </ul>
            </div>

            <div class="aboutCard">
                <h2>🎯 Our Vision</h2>
                <p>
                    We believe social media should feel calm, personal, and empowering.
                    Zenkai is built with performance, privacy, and user experience in mind.
                </p>
            </div>

            <div class="aboutCard contactCard">
                <h2>📩 Contact & Support</h2>
                <p>
                    Have feedback, ideas, or found a bug?
                    We’d love to hear from you.
                </p>

                <a href="mailto:support@zenkai.com" class="contactBtn">
                    Contact Support
                </a>
            </div>

        </section>


        <?php include "./components/rightSideBar.php" ?>
    </main>
    <script src="./js/theme.js"></script>
</body>

</html>