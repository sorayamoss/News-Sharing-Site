<?php
require 'database.php';

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

// password hashing
$hashedpassword = password_hash($password, PASSWORD_DEFAULT);


// adds new user to database
$stmt = $mysqli->prepare("insert into users (username, password) values (?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	echo "Invalid Username";
	exit;
}

$stmt->bind_param('ss', $username, $hashedpassword);

$stmt->execute();

$stmt->close();




header("Location: login.html");


?>
