<?php
require 'database.php';
session_start();
// check csrf token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$sID = $_POST['storyID'];
$currentUser = $_SESSION['user_id'];
$theComment = $_POST['theComment'];
// code to remove comment from database then go back to current story
$stmt = $mysqli->prepare("delete from comments where comment=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('s', $theComment);

$stmt->execute();

header("Location: stories.php?storyID=".$sID);
 ?>
