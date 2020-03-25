<?php
session_start();
include '../../connection.php';
$id = $_SESSION['uid'];
if (isset($_POST['search'])) {
	 $search = $_POST['search'];
	 $stmt = $conn->prepare("SELECT * FROM diaries WHERE user_id = $id AND content LIKE '%".$search."%'");
	 $stmt->execute();
	 $rows = $stmt->fetchAll();
	 echo '<ul class="list-unstyled">';
	 foreach ($rows as $row) {
	 	echo '<li><div class="alert alert-success">'.$row['content'].'</div></li>';
	 }
	echo '</ul>';

}


?>