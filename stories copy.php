<!DOCTYPE html>

<html>
<head>
  <meta charset="utf-8">
  <title>Story</title>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <?php
  require 'database.php';
  session_start();


  $sID = $_GET['storyID'];

  // checks to see if there is a current logged in user
  if(empty($_SESSION['user_id'])){
    $currentUser= 'nouser';
  }
  else{
      $currentUser= $_SESSION['user_id'];
        $token = $_SESSION['token'];
  }
  //checks to see which story was selected, retrieves from database
  $stmt = $mysqli->prepare("select name, username, link, content from Stories where id=?");
  if(!$stmt){

    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt->bind_param('i', $sID);

  $stmt->execute();

  $stmt->bind_result($title, $author, $link, $story);
  $stmt->fetch();

// prints out story
  echo "<h1>". htmlentities($title) . "</h1>";
  echo "<h2> By: " . htmlentities($author) . "</h2>";
  echo "<p> " . htmlentities($story) . "</p>";
  if ($link!=null){
  echo "<a href='". htmlentities($link). "'>Link</a>";
  }

  $stmt->close();

  if ($currentUser == $author){


    //this is our delete button
    echo "<form method='post' action='delete.php'>";
    printf("\t<input type='hidden' name='storyID' value='%u'>\n",
    htmlspecialchars($sID)
  );
  echo '<input type="hidden" name="token" value="'.htmlentities($token).'" />';
  echo "<input value='Delete Story' type='submit'>";
  echo "</form>";


  // this is our edit button
  echo "<form method='post' action='edit.php'>";
  printf("\t<input type='hidden' name='storyID' value='%u'>\n",
  htmlspecialchars($sID)
);
  echo '<input type="hidden" name="token" value="'.htmlentities($token).'" />';
echo "<input value='Edit Story' type='submit'>";
echo "</form>";


}//end checking if user and author the same

if($currentUser!='nouser'){
//create comment code
echo '<form method="post" action="comment.php">';
echo '<input type="text" name="comment"/>';
echo '<input type="hidden" name="token" value="'.htmlentities($token).'" />';
printf("\t<input type='hidden' name='storyID' value='%u'>\n",
htmlspecialchars($sID)
);
echo '<input type="submit" value="Submit Comment"/>';
echo '</form>';


//like button
echo '<form method="post" action="like.php">';
printf("\t<input type='hidden' name='mystoryID' value='%u'>\n",
htmlspecialchars($sID)
);
  echo '<input type="hidden" name="token" value="'.htmlentities($token).'" />';
echo '<input type="submit" value="Like"/>';
echo '</form>';

}//end checking if no user has been created




// print all comments with story id at the bottom of page
$stmt = $mysqli->prepare("select username, comment from comments where id=?");
if(!$stmt){
  printf("Query Prep Failed: %s\n", $mysqli->error);
  exit;
}

$stmt->bind_param('i', $sID);

$stmt->execute();

$stmt->bind_result($commentUser, $commentContent);

echo "<ul>\n";
while($stmt->fetch()){
  printf("\t<li>%s : %s</li>\n",
  htmlspecialchars($commentUser),
  htmlspecialchars($commentContent)
);






//this is the form for delete comment
if($commentUser == $currentUser){
  echo "<form method='post' action='commentDelete.php'>";
  printf("\t<input type='hidden' name='storyID' value='%u'>\n",
  htmlspecialchars($sID)
);
echo '<input type="hidden" name="token" value="'.$token.'" />';
printf("\t<input type='hidden' name='theComment' value='%s'>\n",
htmlspecialchars($commentContent)
);
echo "<input value='Delete Comment' type='submit'>";
echo "</form>";


//this is the form for edit comments
echo "<form method='post' action='commentEdit.php'>";
printf("\t<input type='hidden' name='storyID' value='%u'>\n",
htmlspecialchars($sID)
);
echo '<input type="hidden" name="token" value="'.$token.'" />';
printf("\t<input type='hidden' name='theComment' value='%s'>\n",
htmlspecialchars($commentContent)
);
echo "<input value='Edit Comment' type='submit'>";
echo "</form>";




}
}
echo "</ul>\n";
$stmt->close();

?>


<!-- sends user back to main page -->
<form action="main.php">
  <input type="submit" value="Back to Main"/>
</form>


</body>
</html>
