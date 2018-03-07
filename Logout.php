<?php
session_start();
$_SESSION["user_id"]=0;
session_destroy();
echo "<script>window.location.href='Home.php';</script>";
?>