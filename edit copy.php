<?php
require 'database.php';
session_start();

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

$sID = $_POST['storyID'];
$currentUser = $_SESSION['user_id'];
// pull the story name username and link so user can edit in form below
$stmt = $mysqli->prepare("select name, username, link, content from Stories where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();

$stmt->bind_result($title, $author, $link, $story);
$stmt->fetch();


// add form to edit story and pull in current data
echo '<form name="makePost" id= "mkpst" method="post" action="update.php">';
echo 'Title of Post: <input value="'.htmlentities($title).'" type="text" name="title"/> <br>';
echo 'Contents of Post: <textarea form= "mkpst" name="content">'.htmlentities($story).' </textarea>';
echo 'Link: <input type="url" value="'.htmlentities($link).'"name="link"/> <br>';
printf("\t<input type='hidden' name='storyID' value='%u'>\n",
htmlspecialchars($sID)
);
echo '<input type="submit" value="Update Post"/>';
echo '</form>';


$stmt->close();
 ?>
