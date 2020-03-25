<?php
session_start();
include '../../connection.php';
if (isset($_POST['email'])) {

	 $email = $_POST['email'];
	 $password = sha1($_POST['password']);

	 $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
	 $stmt->execute(array($email,$password));
	 $getUser = $stmt->fetch();
	 $count= $stmt->rowCount();

	 if ($count>0) {
				$_SESSION['email']= $email;//register session email
				$_SESSION['uid'] = $getUser['id']; // Register User ID in session
				$Msg = '<div class="alert alert-success">Login <strong>Successful</strong> You Will Be Redirect After <strong>5 Seconds</strong></div>';
				echo $Msg;
	 }else{

	 	if (empty($email)) {

	 		echo '<div class="alert alert-danger">The <strong>Email</strong> C\'ant Be Empty</div>';
	 	
	 	}elseif(empty($_POST['password'])){
	 		
	 		echo '<div class="alert alert-danger">The <strong>Password</strong> C\'ant Be Empty</div>';
	 	
	 	}else{
	 	
	 		echo '<div class="alert alert-danger">Not Valid <strong>Email</strong> or <strong>Password</strong></div>';
	 	
	 	}
	 	
	 }

}

?>
