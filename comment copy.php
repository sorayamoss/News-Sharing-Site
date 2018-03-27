<?php
require 'database.php';
session_start();
// check for csrf token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$sID = $_POST['storyID'];
$currentUser = $_SESSION['user_id'];
$comment = $_POST['comment'];

// code to add comment to the database hooked to a story then take back to story page

$stmt = $mysqli->prepare("insert into comments (username, comment, id) values (?, ?, ?)");


if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}

$stmt->bind_param('sss', $currentUser, $comment, $sID);

$stmt->execute();

$stmt->close();


header("Location: stories.php?storyID=".$sID);



?>
