<?php
require 'database.php';
session_start();
// checks csrf token
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$title = $_POST['title'];
$username =$_SESSION['user_id'];
$content = $_POST['content'];
$link = $_POST['link'];
// preps story with prepare statement NO SQL INJECT
$stmt = $mysqli->prepare("insert into Stories (name, username, link, content) values (?, ?, ?, ?)");


if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}

$stmt->bind_param('ssss', $title, $username, $link, $content);

$stmt->execute();

$stmt->close();


header("Location: main.php");




?>
