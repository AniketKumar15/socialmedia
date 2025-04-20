<?php
include "./components/getUserData.php";
?>
<nav>
    <div class="logoContainer">
        <a href="index.php"><img src="./Img/LogoIconLight.png" alt="Zenkai Logo" class="logo"></a>
        <h1 class="logoText">enkai</h1>
    </div>
    <?php if (!isset($_SESSION["username"])): ?>
        <a href="./account.php" class="loginBtn">Login</a>
    <?php else: ?>
        <div class="userProfile">
            <img src=<?= $profilePic ?> alt="">
            <p class="username"><?php echo $_SESSION["username"]; ?></p>
            <p class="dropbtn"><i class="fa-solid fa-caret-down"></i></p>
            <div class="dropdown">
                <div class="dropdown-content">
                    <a href="profile.php?user_id=<?= urlencode($_SESSION['id']) ?>"><i class="fa-solid fa-circle-user"></i>
                        Profile</a> <!--Later Add profile.php -->
                    <a href="http://localhost/socialmedia/Backend/api/logout.php"><i
                            class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</nav>