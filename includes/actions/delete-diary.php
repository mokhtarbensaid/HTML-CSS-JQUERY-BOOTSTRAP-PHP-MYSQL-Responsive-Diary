<?php
session_start();
include '../../connection.php';
// check get request diaryid is numeric and get the integer value for it
 $diaryid = isset($_GET['diaryid']) && is_numeric($_GET['diaryid']) ? intval($_GET['diaryid']) :0 ;
 $stmt =$conn->prepare("SELECT id FROM diaries WHERE id = $diaryid");
 $stmt->execute();
 $count = $stmt->rowCount();
 
 if ($count>0) {
 	$stmt = $conn->prepare("DELETE FROM diaries WHERE id = :zdiaryid");

 	//Bind between the parameter :zuser and $userid
	$stmt->bindParam(":zdiaryid", $diaryid);
 	$stmt->execute();
 	header("location:../../index.php");
 }else{
 	echo '<div class="alert alert-danger">This ID is not exist in the database</div>';
 	header("refresh:3; url=../../index.php");
 }


?>