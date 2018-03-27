<?php
require 'database.php';
session_start();

$sID = $_POST['storyID'];
$updatedComment = $_POST['comment'];
$oldComment = $_POST['oldcom'];


//matches old comment with comID
$stmt = $mysqli->prepare("select comID from comments where comment=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $oldComment);
$stmt->execute();
$stmt->bind_result($cID);
$stmt->fetch();
$stmt->close();

//end of new added code



// echo $updatedComment;
// echo $oldComment;


// updates matched comment with new comment content
$stmt = $mysqli->prepare("update comments set comment = '".$updatedComment."' where comID=".$cID);
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  echo "Invalid Submission";
  exit;
}

$stmt->bind_param('s', $updatedComment);

$stmt->execute();

$stmt->close();


header("Location: stories.php?storyID=".$sID);




?>
