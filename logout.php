<?php
//@include 'db.php';
/**
 * This page acts as a session destroyer and re-direct to the login page. 
 * Effectively, this logs the user out. 
 */
session_start();
session_unset();
session_destroy();

header('location:index.php');
exit();
?>
