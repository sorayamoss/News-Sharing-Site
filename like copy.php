<?php
require 'database.php';
session_start();
// check csrf
if(!hash_equals($_SESSION['token'], $_POST['token'])){
  die("Request forgery detected");
}

$sID = $_POST['mystoryID'];
$username =$_SESSION['user_id'];

// figure out how many likes currently
$stmt = $mysqli->prepare("select likes from Stories where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();

$stmt->bind_result($numLikes);
$stmt->fetch();


$stmt->close();


$stmt = $mysqli->prepare("insert into likelog (username, id) values (?, ?)");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}


$stmt->bind_param('ss',  $username, $sID);

$stmt->execute();

$stmt->close();

// Check number of likes
$stmt = $mysqli->prepare("select COUNT(*) from likelog where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);
$stmt->execute();

$stmt->bind_result($numLikes);
$stmt->fetch();


$stmt->close();


echo $numLikes;
// update number of likes
$stmt = $mysqli->prepare("update Stories set likes = '".$numLikes."' where id=".$sID);
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}

$stmt->bind_param('i', $numLikes);

$stmt->execute();

$stmt->close();


header("Location: stories.php?storyID=".$sID);

?>
