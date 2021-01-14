<?php
	include('./includes/connection.php');
	$obj = new myconn;
	$conn = $obj->connection();
	$res = $conn->prepare("UPDATE `chat_userdata` SET online=0 WHERE id = {$_SESSION['id']};");
	$res->execute();
	session_destroy();
	setcookie("uname","",time());
	header("location: ./index.php");
?>