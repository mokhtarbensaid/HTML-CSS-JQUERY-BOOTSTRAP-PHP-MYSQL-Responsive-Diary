<?php
session_start();
include 'initial.php';
include $templates.'navbar.php';
if (!isset($_SESSION['email'])) {
	header('location:login.php');
}
 $id = $_SESSION['uid'];
 $stmt=$conn->prepare("SELECT * FROM users WHERE id = $id");
 $stmt->execute();
 $row = $stmt->fetch();
?>
<div class="account">
	<div class="container">
		<h1 class="custom-title text-center">My Account</h1>
		<div class="row">
			<div class="col-md-6">
				<div class="card border-secondary mb-3">
				  <div class="card-header">Update Information</div>
				  <div class="card-body text-secondary">
					<form method="post" action="" class="form-update">
						<h3 class="login-form-title text-center">Fill The Fields To Sign Up <i class="fas fa-pen-nib"></i></h3>
					  <span id="form-response"></span>
					  <div class="form-group">
					    <label for="name-field">Your Name</label>
					    <input type="text" name="name" class="form-control name" value="<?php echo $row['name'] ?>" id="name-field" placeholder="Ex: John Smith">
					  </div>
					  <div class="form-group">
					    <label for="Email-field">Email address</label>
					    <input type="email" name="email" value="<?php echo $row['email'] ?>" class="form-control email" id="Email-field" aria-describedby="emailHelp" placeholder="Ex: john@example">
					    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					  </div>
					  <div class="form-group">
					    <label for="password-field">Password</label>
					    <input type="hidden" class="oldPassword" value="<?php echo $row['password'] ?>" >
					    <input type="password" class="form-control newPassword" id="password-field" placeholder="Leave Blank If You Don't Want to Change It">
					  </div>
					  <button class="update-btn btn custom-btn">Update <i class="fas fa-check-circle"></i></button>
					</form>
				  </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card border-secondary mb-3">
				  <div class="card-header">Settings</div>
				  <div class="card-body text-secondary">
				  	<label style="display: block;">Delete My Account:</label>
				  	
					<!-- Button trigger modal -->
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
					  <i class="fas fa-trash-alt"></i> Delete
					</button>

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Delete My Account</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p>Do You Want To Delete Your Account?</p>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="button" class="btn btn-danger"><a href="includes/actions/delete-account.php"><i class="fas fa-trash-alt"></i> Delete</a></button>
					      </div>
					    </div>
					  </div>
					</div>
				  </div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php
include $templates.'footer.php';
?>
<script type="text/javascript">
 $(document).ready(function(){
  $(".update-btn").click(function(e){
  e.preventDefault();
  var $form=$(this).closest(".form-update");
  var name      = $form.find(".name").val();
  var email     = $form.find(".email").val();
  var newPassword  = $form.find(".newPassword").val();
  var oldPassword  = $form.find(".oldPassword").val();
  $.ajax({
   url: 'includes/actions/update-account.php',
   method: 'post',
   data: {email:email,newPassword:newPassword,oldPassword:oldPassword,name:name},
      success:function(response){
   $("#form-response").html(response);
      }
  });
 });
 });
 </script>