<?php
session_start();
if (!isset($_SESSION['email'])) {
	header('location:login.php');
}
include '../../connection.php';
 $id = $_SESSION['uid'];
if (isset($_POST['email'])) {
	 $name     = $_POST['name'];
	 $email    = $_POST['email'];

	 // Filter Info From Any Hack
	 $filteredName = filter_var($name, FILTER_SANITIZE_STRING);
	 $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

	 $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND id !=? ");
	 $stmt->execute(array($email, $id));
	 $getUser = $stmt->fetch();
	 $count= $stmt->rowCount();

	 if ($count>0) {
				echo  '<div class="alert alert-danger">Sorry,This Email Already Exist</div>';

	 }else{

	 	$pass=empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);

	 	$formErrors = array();
	 	if (empty($filteredName)) {

	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Name</strong> C\'ant Be Empty</div>';
	 	
	 	}
	 	if (strlen($filteredName)< 5 ) {

	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Name</strong> Must Be Larger Than <strong>5 Characters</strong></div>';
	 	
	 	}
	 	if (empty($filteredEmail)) {

	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Email</strong> C\'ant Be Empty</div>';
	 	
	 	}
	 	
	 	// check if the email is valid
		if (filter_var($filteredEmail,FILTER_VALIDATE_EMAIL)==FALSE) {

 			$formErrors[] = '<div class="alert alert-danger">Please Enter a <strong>Valid Email Address</strong></div>';
	 	
	 	}
	 	if(empty($_POST['newPassword']) && empty($_POST['oldPassword'])){
	 		
	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Password</strong> C\'ant Be Empty</div>';
	 	
	 	}
	 	if (strlen($_POST['newPassword'])< 4  && empty($_POST['oldPassword'])) {

	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Password</strong> Must Be Larger Than <strong>4 Characters</strong></div>';
	 	
	 	}
	 	 //Loop into errors array named'$formErrors' and echo it
 			foreach ($formErrors as $error) {
 				echo $error ;
 			}
	 	if (empty($formErrors)) {

	 		$stmt = $conn->prepare("UPDATE users SET name= ? , email = ?, password = ? WHERE id = ?");
	 		$stmt->execute(array($filteredName, $filteredEmail, $pass, $id));

	 		echo '<div class="alert alert-success">Your <strong>Informatoins</strong>  Are Updated!!</div>';

	 	}
	 	
	 }

}
?>