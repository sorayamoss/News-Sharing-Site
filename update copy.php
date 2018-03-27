<?php
require 'database.php';
session_start();

$sID = $_POST['storyID'];
$title = $_POST['title'];
$username =$_SESSION['user_id'];
$content = $_POST['content'];
$link = $_POST['link'];

//updates the story data in the database
$stmt = $mysqli->prepare("update Stories set name = '".$title."', link='".$link."', content='".$content."' where id=".$sID);


if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}

$stmt->bind_param('sss', $title, $link, $content);

$stmt->execute();

$stmt->close();


header("Location: stories.php?storyID=".$sID);




?>
