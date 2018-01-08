<?php

// include function files for this application
session_start();
$old_user = $_SESSION['user'];  // store  to test if they *were* logged in
unset($_SESSION['user']);
session_destroy();

header("location:index.php");
?>

