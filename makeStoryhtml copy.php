<!DOCTYPE html>

<?php
session_start();
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
?>

<html>
<head>
  <meta charset="utf-8">
  <title>Make a Post</title>
  <!-- linking fontawesome -->
  <script src="https://use.fontawesome.com/89281ccf9c.js"></script>
  <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
  <div class="center-text">
    <h1 class="login">Make a Post</h1>


		<!-- form to create a new story -->
    <form name="makePost" id= "mkpst" method="post" action="makeStory.php">
      Title of Post: <input type="text" name="title"/> <br>
      Contents of Post: <textarea form= "mkpst" name="content"> </textarea>
      Link: <input type="url" name="link"/> <br>
      <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
      <input type="submit" value="Post"/>
    </form>

		
	<!-- sends user back to main news page -->
    <form action="main.php">
      <input type="submit" value="Back to Main"/>
    </form>

  </div>
</body>
</html>
