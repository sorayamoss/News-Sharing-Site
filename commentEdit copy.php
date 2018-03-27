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
$prevComment = $_POST['theComment'];
// code to pull what the comment in the database is so we can change it later
$stmt = $mysqli->prepare("select comment from comments where comment=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('s', $theComment);

$stmt->execute();

$stmt->bind_result($theComment);
$stmt->fetch();

// form to edit comment
//DO NOT NEED TO DO CSRF BC THIS IS BEING INPUTTED FROM DATA BASe entries and its already checked previously
echo '<form name="editComment" id= "editComment" method="post" action="updateComment.php">';
echo 'Updated Comment: <input value="'.htmlentities($theComment).'" type="text" name="comment"/> <br>';
printf("\t<input type='hidden' name='storyID' value='%u'>\n",
htmlspecialchars($sID)
);
printf("\t<input type='hidden' name='oldcom' value='%s'>\n",
htmlspecialchars($prevComment)
);
echo '<input type="submit" value="Update Comment"/>';
echo '</form>';


$stmt->close();
 ?>
