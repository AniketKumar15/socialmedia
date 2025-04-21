<aside class="leftSideBar">
    <h1>Options</h1>
    <ul class="optionsList">
        <li><a href="index.php"><i class="fa-solid fa-house"></i> Home</a></li>
        <li><a href="profile.php?user_id=<?= urlencode($_SESSION['id']) ?>"><i class="fa-solid fa-user"></i> Profile</a>
        </li>
        <li><a href="friends.php?user_id=<?= urlencode($_SESSION['id']) ?>"><i class="fa-solid fa-users"></i>
                Friends</a></li>
        <li><a href="#"><i class="fa-solid fa-comment"></i> Messages</a></li>
        <li><a href="notification.php"><i class="fa-solid fa-bell"></i>
                Notifications <i class="fa-solid fa-circle NotificationsIcon" style="color:rgb(255, 2, 2);"></i></a>
        </li>
        <li><a href="#"><i class="fa-solid fa-gear"></i> Settings</a></li>
        <li><a href="#"><i class="fa-solid fa-circle-info"></i> About</a></li>
        <li><a href="http://localhost/socialmedia/Backend/api/logout.php"><i class="fa-solid fa-right-from-bracket"></i>
                Logout</a></li>
    </ul>
    <ul class="optionsListSmall">
        <li><a href="index.php"><i class="fa-solid fa-house"></i></a></li>
        <li><a href="profile.php?user_id=<?= urlencode($_SESSION['id']) ?>"><i class="fa-solid fa-user"></i></a></li>
        <li><a href="friends.php?user_id=<?= urlencode($_SESSION['id']) ?>"><i class="fa-solid fa-users"></i></a></li>
        <li><a href="#"><i class="fa-solid fa-comment"></i></a></li>
        <li><a href="#"><i class="fa-solid fa-bell"></i></a></li>
        <li><a href="#"><i class="fa-solid fa-gear"></i></a></li>
        <li><a href="#"><i class="fa-solid fa-circle-info"></i></a></li>
        <li><a href="http://localhost/socialmedia/Backend/api/logout.php"><i
                    class="fa-solid fa-right-from-bracket"></i></a></li>
    </ul>
</aside>