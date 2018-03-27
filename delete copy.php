<?php
require 'database.php';
session_start();

// if(!hash_equals($_SESSION['token'], $_POST['token'])){
// 	die("Request forgery detected");
// }

$sID = $_POST['storyID'];
$currentUser = $_SESSION['user_id'];

// delete the likes since they are tied with foreign key

$stmt = $mysqli->prepare("delete from likelog where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();

// delete the comments since they are tied with foreign key
$stmt = $mysqli->prepare("delete from comments where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();

// delete stories from database now that foreign keys deleted
$stmt = $mysqli->prepare("delete from Stories where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();
$stmt->close();

header("Location: main.php");
 ?>
