<?php
// destroys session on log out
session_start();
session_destroy();
// takes back to main page as non logged in user
header("Location: main.php");
?>
