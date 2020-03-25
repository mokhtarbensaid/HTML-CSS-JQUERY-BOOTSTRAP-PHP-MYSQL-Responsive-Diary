<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
include 'initial.php';
include $templates.'navbar.php';
 $id = $_SESSION['uid'];
 if ($_SERVER['REQUEST_METHOD']=="POST") {
 	$title   = $_POST['title'];
 	$date    = $_POST['date'];
 	$content = $_POST['content'];

	 // Filter Info From Any Hack
	 $filteredTitle = filter_var($title, FILTER_SANITIZE_STRING);
	 $filteredContent = filter_var($content, FILTER_SANITIZE_STRING);

 	$stmt = $conn->prepare("INSERT INTO diaries(user_id, title, content, date, time)
 							VALUES(:zuserId, :ztitle, :zcontent, :zdate, now())
 	");
 	$stmt->execute(array(
 		':zuserId' => $id,
 		':ztitle'  => $filteredTitle,
 		':zcontent'=> $filteredContent,
 		':zdate'   => $date
 	));
 	header("location:index.php");
 } 
?>
<div class="new-diary">
	<div class="container">
		<h1 class="text-center custom-title">Write New Diary</h1>
		<div class="row">
			<div class="new-diary-box">
				<form class="new-diary-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				  <div class="form-row">
				    <div class="col-md-9">
				      <input type="text" name="title" class="form-control" placeholder="Title">
				    </div>
				    <div class="col-md-3">
				      <div class="input-group mb-3">
						  <input type="date" class="form-control" value="<?php echo date("Y-m-j") ?>" name="date">
						  <div class="input-group-append">
						    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
						  </div>
						</div>
				    </div>
				  </div>
				  <div class="form-group">
				  	<textarea class="form-control" rows="10" name="content" placeholder="What Happened Today?"></textarea>
				  </div>
				  <button type="submit" class="btn custom-btn float-right"><i class="fas fa-edit"></i> Save & Close</button>
				  <button type="button" class="btn btn-secondary float-right mr-2"><a href="index.php"><i class="fas fa-times"></i> Cancel</a></button>
				</form>
		    </div>
		</div>
	</div>
</div>


<?php
include $templates.'footer.php';
?>