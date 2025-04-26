<script>
    fetch('http://localhost/socialmedia/backend/api/markNotificationsRead.php', {
        method: 'POST'
    })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                document.querySelector('.NotificationsIcon').style.display = 'none';
            }
        });

</script>
<?php
session_start();
include "../Backend/db/db.php";

if (!isset($_SESSION["id"])) {
    header("Location: ./account.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
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
            <div class="notificationsContainer" id="notificationsContainer">
                <p>Loading notifications...</p>
            </div>
        </section>
        <?php include "./components/rightSideBar.php" ?>
    </main>
    <script src="./js/notifications.js"></script>
    <script src="./js/checkNotification.js"></script>
</body>

</html>