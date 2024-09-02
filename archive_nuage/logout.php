<?php 
session_start(); 
session_destroy();
header("location: profil.php");
exit();
?>