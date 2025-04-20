<?php
$id = $_SESSION["id"];
$sql = "SELECT * FROM userdata WHERE id = $id";
$res = $conn->query($sql);
$row = $res->fetch_assoc();

$profilePic = !empty($row['profile_pic']) ? "../" . $row['profile_pic'] : './Img/avatar.png';

?>