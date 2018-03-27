<!-- this will get called(required by every php file that wants to use the database) -->
<?php
// Content of database.php

$mysqli = new mysqli('localhost', 'group', 'group', 'newsSite');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>
