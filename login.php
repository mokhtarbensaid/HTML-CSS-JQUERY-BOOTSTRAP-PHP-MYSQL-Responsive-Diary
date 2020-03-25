<?php
session_start();
include 'initial.php';
if (isset($_SESSION['email'])) {
	header('location:index.php');
}

?>
<div class="login">
	<div class="container">
		<div class="login-form">
			<h1 class="login-title text-center">Welcome Back in Your Diary</h1>
			<p class="login-desc text-center">Write your diary and notes easily and safely</p>
			<form method="post" action="" class="form-login">
				<h3 class="login-form-title text-center">Login to Start Write <i class="fas fa-pen-nib"></i></h3>
			  <span id="form-response"></span>
			  <div class="form-group">
			    <label for="Email-field">Email address</label>
			    <input type="email" name="email" class="form-control email" id="Email-field" aria-describedby="emailHelp" placeholder="Ex: john@example">
			    <i class="fas fa-at"></i>
			    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			  </div>
			  <div class="form-group password-form-group">
			    <label for="password-field">Password</label>
			    <input type="password" name="password" class="form-control password" id="password-field" placeholder="Ex: xxxxxxx">
			    <i class="fas fa-unlock"></i>
			    <i class="fas fa-eye"></i>
			    <i class="fas fa-eye-slash"></i>
			  </div>
			  <button class="login-btn btn custom-btn">Login <i class="fas fa-sign-in-alt"></i></button>
			  <p  class="text-center">You Don't Have Account? <a href="signup.php">Sign Up</a> Now!!</p>
			</form>
		</div>
	</div>
</div>


<?php
include $templates.'footer.php';

?>
<script type="text/javascript">
 $(document).ready(function(){
  $(".login-btn").click(function(e){
  e.preventDefault();
  var $form=$(this).closest(".form-login");
  var email     = $form.find(".email").val();
  var password  = $form.find(".password").val();
  $.ajax({
   url: 'includes/actions/login.php',
   method: 'post',
   data: {email:email,password:password},
      success:function(response){
   $("#form-response").html(response);  
 
 		if (response=='<div class="alert alert-success">Login <strong>Successful</strong> You Will Be Redirect After <strong>5 Seconds</strong></div>') {
            window.setTimeout(function() {
   	          window.location.href = 'index.php';
          }, 5000);

 	   }
      }
  });
 });
 });
 </script>