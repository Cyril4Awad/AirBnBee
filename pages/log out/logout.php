<?php
session_start();
unset($_SESSION["userId"]);
unset($_SESSION["fname"]);
header("Location:../home page/startpage.php");
?>