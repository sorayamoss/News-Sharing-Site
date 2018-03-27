<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Main</title>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

  <?php
  require 'database.php';
  session_start();


  echo "<h1>Moss Margolis News</h1>";
// echo "<h1>Welcome to Cannibalism</h1>";
  // echo '<div class="row">';
  // echo '<div id = "story-column" class="col-8">';

  if(empty($_SESSION['user_id'])){
    $currentUser= 'nouser';

  }
  else{
      $currentUser= $_SESSION['user_id'];
      $token = $_SESSION['token'];
  }

  $stmt = $mysqli->prepare("select id, name, username, likes from Stories order by likes desc");
  if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
  }

  $stmt->execute();

  $stmt->bind_result($id, $title, $author, $numLikes);

  while($stmt->fetch()){
    echo "<form method='get' action='stories.php'>";
    printf("\t<input type='hidden' name='storyID' value='%u'>\n",
    htmlspecialchars($id)
  );
  echo "<input value='" . htmlentities($title) . "' type='submit'>";
  echo "</form>";
  echo "<span>".htmlentities($numLikes)." likes </span>";
}
$stmt->close();


if($currentUser!='nouser'){
  //make story
  echo '<form method="post" action="makeStoryhtml.php">';
  echo '<input type="submit" value="Create story"/>';
  echo '<input type="hidden" name="token" value="'.htmlentities($token).'" />';
  echo '</form>';

  // echo '</div>';
  // echo '<div class="col-4">';

  echo "<h1>Your Likes</h1>";
    $stmt = $mysqli->prepare("select likelog.id, Stories.name from likelog join Stories on (likelog.id=Stories.id) where likelog.username=?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('s', $currentUser);

    $stmt->execute();

    $stmt->bind_result($sID, $title);

    while($stmt->fetch()){
      echo "<ul>";
      echo "<li>".htmlentities($title)."</li>";
      echo "</ul>";

      }
  $stmt->close();
  // echo '</div>';
  // echo '</div>';

//logout
  echo '<form action="logout.php">';
echo '<input type="submit" value="Log out"/>';
echo '</form>';
}//end checking if no user has been created


else{
  echo '<form action="login.html">';
echo '<input type="submit" value="Login"/>';
echo '</form>';
}

?>



</body>
</html>
