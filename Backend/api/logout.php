<?php
session_start();
// Destroy the session to log out the user
session_destroy();
session_unset();
header("Location: ../../Frontend/account.php");
?>