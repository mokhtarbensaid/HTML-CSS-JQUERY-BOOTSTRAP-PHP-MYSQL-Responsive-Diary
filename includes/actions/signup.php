<?php
session_start();
include '../../connection.php';
if (isset($_POST['email'])) {
	 $name     = $_POST['name'];
	 $email    = $_POST['email'];
	 $password = sha1($_POST['password']);

	 // Filter Info From Any Hack
	  $filteredName = filter_var($name, FILTER_SANITIZE_STRING);
	  $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

	 $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
	 $stmt->execute(array($filteredEmail));
	 $getUser = $stmt->fetch();
	 $count= $stmt->rowCount();

	 if ($count>0) {
				echo  '<div class="alert alert-danger">Sorry,This Email Already Exist</div>';

	 }else{

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
	 	if(empty($_POST['password'])){
	 		
	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Password</strong> C\'ant Be Empty</div>';
	 	
	 	}
	 	if(!preg_match('`[A-Z]`', $_POST['password'])){
	 		
	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Password</strong> Must Be Include <strong>Capital Letter</strong></div>';
	 	
	 	}
	 	if (strlen($_POST['password'])< 4 ) {

	 		$formErrors[] = '<div class="alert alert-danger">The <strong>Password</strong> Must Be Larger Than <strong>4 Characters</strong></div>';
	 	
	 	}
	 	 //Loop into errors array named'$formErrors' and echo it
 			foreach ($formErrors as $error) {

 				echo $error ;
 				
 			}
	 	if (empty($formErrors)) {

	 		$stmt = $conn->prepare("INSERT INTO users(name, email, password) VALUES(:zname, :zemail, :zpassword)");
	 		$stmt->execute(array(
	 			':zname'=>$filteredName,
	 			':zemail'=>$filteredEmail,
	 			':zpassword'=>$password
	 		));
	 		$successMsg= '<div class="alert alert-success"><strong>Congratulations</strong> Your Are subscribed!<br/>You Will Be Redirect to Login Page After <strong>5 Seconds</strong></div>';
	 		echo $successMsg;
	 	}

	 	
	 }

}


?>