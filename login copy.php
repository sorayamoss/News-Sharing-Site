<?php
// This is a *good* example of how you can implement password-based user authentication in your web application.
//start session -added
session_start();
require 'database.php';

// Use a prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$user = $_POST['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($cnt, $pwd_hash);
$stmt->fetch();

$pwd_guess = $_POST['password'];
// Compare the submitted password to the actual password hash

if($cnt == 1 && password_verify($pwd_guess, $pwd_hash)){
  // Login succeeded!
  $_SESSION['user_id'] = $user;
  //CSRF token creation
  $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
  // Redirect to your target page
  header("Location: main.php");
} else{
  // Login failed; redirect back to the login screen
  header("Location:invalid.html");
  exit;
}
?>
