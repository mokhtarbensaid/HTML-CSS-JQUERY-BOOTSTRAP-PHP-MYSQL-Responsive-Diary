<?php
session_start();

if (!isset($_SESSION['email'])) {
	header('location:login.php');
}
include '../../connection.php';
    $id = $_SESSION['uid'];

 	$stmt = $conn->prepare("DELETE FROM users WHERE id = :zid");

 	//Bind between the parameter :zuser and $userid
	$stmt->bindParam(":zid", $id);
 	$stmt->execute();
 	
	session_unset(); //unset the session

	session_destroy(); //destroy th esession

 	header("location:../../login.php");
 


?>