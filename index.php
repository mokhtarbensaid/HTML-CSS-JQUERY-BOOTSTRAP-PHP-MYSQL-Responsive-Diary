<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
include 'initial.php';
include $templates.'navbar.php';

// check get request year is numeric and get the integer value for it
 $yearid = isset($_GET['year']) && is_numeric($_GET['year']) ? intval($_GET['year']) :0 ;
 // current year
 $curYear = date("Y");
 $id = $_SESSION['uid'];

$stmt = $conn->prepare("SELECT * FROM diaries WHERE DATE_FORMAT(date,'%Y')= $curYear AND user_id = $id ORDER BY date DESC LIMIT 5");

if (isset($_GET['year']) && is_numeric($_GET['year'])) {
 $stmt = $conn->prepare("SELECT * FROM diaries WHERE DATE_FORMAT(date,'%Y')= $yearid AND user_id = $id ORDER BY date DESC LIMIT 5");
}

$stmt->execute();
$rows = $stmt->fetchAll();



?>
<div class="dashboard">
  <h1 class="custom-title text-center">My Dashboard</h1>   
  <div class="container">
    <div class="search-box">
      <select class="form-control year" onchange="location = this.value;">
          <?php
          $stmt3 = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%Y') AS Year FROM diaries WHERE user_id = $id ORDER BY Year");
          $stmt3->execute();
          $years = $stmt3->fetchAll();
            foreach ($years as $year) {
         
         
           echo '<option value="index.php?year='.$year['Year'].'"';

             if ($year['Year'] == $yearid) {

               echo 'selected';
          }else{

           if ($year['Year'] == $curYear) {

             echo 'selected';
            }
         }
          
         echo '>'.$year['Year'].'</option>';
         } 
         ?>
      </select>

      <div class="search-toggle">
        <i class="fa fa-search"></i> 
         <span class="search-span"> Search</span>
        <span class="toggle-info">
        </span>
      </div>
      <form class="form-inline search-form" method="POST" action="search.php">
        <select name="month" class="form-control">
          <option value="">Month</option>
          <?php
          $stmt2 = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%M') AS Month FROM diaries WHERE user_id = $id");
          $stmt2->execute();
          $months = $stmt2->fetchAll();
            foreach ($months as $month) {
              $Month=$month['month'];
         echo '<option value="'.$month['Month'].'"';
            if ($month['Month'] == $searchMonth) {
              echo 'selected';
            }
         echo '>'.$month['Month'].'</option>';
         } 
         ?>
        </select>
        <select name="year" class="form-control">
          <option value="">Year</option>
          <?php
          $stmt3 = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%Y') AS Year FROM diaries WHERE user_id = $id");
          $stmt3->execute();
          $years = $stmt3->fetchAll();
            foreach ($years as $year) {
         echo '<option value="'.$year['Year'].'"';
          if ($year['Year'] == $searchYear) {
            echo 'selected';
          }
         echo '>'.$year['Year'].'</option>';
         } 
         ?>
        </select>
        <input class="form-control" name="search" type="search" placeholder="Search..." required>
        <button class="btn custom-btn search-btn" name="submit1" type="submit">Search</button>
      </form>
    </div>
    <div class="last-diaries">
      <h3 class="last-diaries-title">My Last Diaries</h3>
      <div class="row">
        <?php
          foreach ($rows as $row) {
             $dateYear = date("D , Y", strtotime($row['date']));
             $dayNumber = date("j<\s\u\p>S</\s\u\p>", strtotime($row['date']));
             $Month = date("M", strtotime($row['date']));
        ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
          <a class="diary-visit-link" href="diary.php?diaryid=<?php echo $row['id']; ?>">
            <div class="diary-box text-center">
              <div class="card mb-3">
                <div class="card-header"><?php echo $Month  ?></div>
                <div class="card-body text-success">
                  <h3 class="diary-num-day"><?php echo $dayNumber ?></h3>
                  <p class="diary-day"><?php echo $dateYear  ?></p>
                  <p class="calendar-icon"><i class="fas fa-calendar-alt"></i></p>
                </div>
              </div>
            </div>
            <span class="diary-pagination"></span>
          </a>
        </div>
        <?php  } ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
          <a class="diary-visit-link" href="newdiary.php">
          <div class="diary-box text-center">
              <div class="card border-success mb-3">
                <div class="card-header"><?php echo date("M");  ?></div>
                <div class="card-body text-success">
                  <h3 class="diary-num-day"><a href="newdiary.php">New <i class="fas fa-plus"></i></a></h3>
                  <p class="diary-day"><?php echo date("d M , Y")  ?></p>
                  <p class="calendar-icon"><i class="fas fa-calendar-alt"></i></p>
                </div>
              </div>
            </div>
            <span class="diary-pagination"></span>
          </a>
        </div>
      </div>
    </div>
    <div class="diaries-months">
      <h3 class="last-diaries-title">My Diaries By Month</h3>
      <div class="row">
        <?php
        $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%M') AS month FROM diaries WHERE user_id = $id");
         if (isset($_GET['year']) && is_numeric($_GET['year'])) {

         $stmt = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%M') AS month FROM diaries WHERE DATE_FORMAT(date,'%Y')= $yearid AND user_id = $id");
        }
        $stmt->execute();
        $months = $stmt->fetchAll();
          foreach ($months as $month) {
             $Year = date("Y", strtotime($row['date']));
             $dayNumber = date("j", strtotime($row['date']));
             $Month = date("n", strtotime($month['month']));

        ?>
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-2">
          <a class="diary-visit-link" href="month-diaries.php?year=<?php 
          if($Year == $yearid){

             echo $Year ;

         }else{

             echo $curYear;

           }?>&monthid=<?php echo $Month; ?>">
            <div class="diary-box text-center">
              <div class="card border-success mb-3">
                <div class="card-header">For Month</div>
                <div class="card-body text-success">
                  <h3 class="diary-num-day"><?php echo $month['month'] ?></h3>
                  <p class="diary-day"><?php echo $Year  ?></p>
                  <p class="calendar-icon"><i class="fas fa-calendar-alt"></i></p>
                </div>
              </div>
            </div>
          </a>
        </div>
        <?php  } ?>
      </div>
    </div>
  </div>
</div>
<?php
include $templates.'footer.php';
?>
