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
			<h1 class="login-title text-center">We Will Happy if You Join Us</h1>
			<p class="login-desc text-center">Write your diary and notes easily and safely</p>
			<form method="post" action="" class="form-signup">
				<h3 class="login-form-title text-center">Fill The Fields To Sign Up <i class="fas fa-pen-nib"></i></h3>
			  <span id="form-response"></span>
			  <div class="form-group">
			    <label for="name-field">Your Name</label>
			    <input type="text" name="name" class="form-control name" id="name-field" placeholder="Ex: John Smith">
			  	<i class="fas fa-user"></i>
			  </div>
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
			  <button class="signup-btn btn custom-btn">Sign Up <i class="fas fa-sign-in-alt"></i></button>
			  <p  class="text-center">Already Have Account? <a href="login.php">Log In</a> Now!!</p>
			</form>
		</div>
	</div>
</div>


<?php
include $templates.'footer.php';

?> 
<script type="text/javascript">
 $(document).ready(function(){
  $(".signup-btn").click(function(e){
  e.preventDefault();
  var $form=$(this).closest(".form-signup");
  var name      = $form.find(".name").val();
  var email     = $form.find(".email").val();
  var password  = $form.find(".password").val();
  $.ajax({
   url: 'includes/actions/signup.php',
   method: 'post',
   data: {email:email,password:password,name:name},
      success:function(response){
   $("#form-response").html(response);
 		if (response=='<div class="alert alert-success"><strong>Congratulations</strong> Your Are subscribed!<br/>You Will Be Redirect to Login Page After <strong>5 Seconds</strong></div>') {
            window.setTimeout(function() {
   	          window.location.href = 'index.php';
          }, 5000);

 	   }
      }
  });
 });
 });
 </script>