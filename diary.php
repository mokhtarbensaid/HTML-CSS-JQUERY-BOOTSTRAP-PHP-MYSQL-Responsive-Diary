<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
include 'initial.php';
include $templates.'navbar.php';
 $id = $_SESSION['uid'];

if ($_SERVER['REQUEST_METHOD']=="POST") {
	$diaryid  = $_POST['diaryid'];
	 $title   = $_POST['title'];
	 $date    = $_POST['date'];
	 $content = $_POST['content'];

	 // Filter Info From Any Hack
	 $filteredTitle = filter_var($title, FILTER_SANITIZE_STRING);
	 $filteredContent = filter_var($content, FILTER_SANITIZE_STRING);

	 		$stmt = $conn->prepare("UPDATE diaries SET title= ? , content = ?, date = ? WHERE id = ?");
	 		$stmt->execute(array($filteredTitle, $filteredContent, $date, $diaryid));
	 		
			header("Location:index.php");

	}
 // check get request diaryid is numeric and get the integer value for it
 $diaryid = isset($_GET['diaryid']) && is_numeric($_GET['diaryid']) ? intval($_GET['diaryid']) :0 ;
 $stmt = $conn->prepare("SELECT * FROM diaries WHERE id = $diaryid");
 $stmt->execute();
 $row = $stmt->fetch();

?>
<div class="new-diary">
	<div class="container">
		<h1 class="text-center custom-title">My Diary</h1>
		<div class="row">
			<div class="new-diary-box">
				<form class="new-diary-form" method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
				  <div class="form-row">
				  	<input type="hidden" name="diaryid" value="<?php echo $diaryid ?>">
				    <div class="col-md-9">
				      <input type="text" name="title" class="form-control" value="<?php echo $row['title'] ?>" placeholder="Title">
				    </div>
				    <div class="col-md-3">
				      <div class="input-group mb-3">
						  <input type="date" class="form-control" value="<?php echo $row['date'] ?>" name="date">
						  <div class="input-group-append">
						    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
						  </div>
						</div>
				    </div>
				  </div>
				  <div class="form-group">
				  	<textarea class="form-control" rows="10" name="content" ><?php echo $row['content'] ?></textarea>
				  </div>
				  <button type="button" class="btn btn-danger"><a href="includes/actions/delete-diary.php?diaryid=<?php echo $diaryid ?>"><i class="fas fa-trash-alt"></i> Delete</a></button>
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