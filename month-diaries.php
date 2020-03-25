<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
include 'initial.php';
include $templates.'navbar.php';
 $id = $_SESSION['uid'];

// check get request year is numeric and get the integer value for it
 $yearid = isset($_GET['year']) && is_numeric($_GET['year']) ? intval($_GET['year']) :0 ;

// check get request monthid is numeric and get the integer value for it
 $monthid = isset($_GET['monthid']) && is_numeric($_GET['monthid']) ? intval($_GET['monthid']) :0 ;

 //For Get Mounth Name From Number of month (03->March)
$dateObj   = DateTime::createFromFormat('!m', $monthid);
$monthName = $dateObj->format('F');
$monthShortName = $dateObj->format('M');



?>
<div class="dashboard">
  <h1 class="custom-title text-center">Diaries For <?php echo $monthName   ?> </h1>      
  <div class="container">
    <div class="search-box">
      <select class="form-control year" onchange="location = this.value;">
          <?php
          $stmt3 = $conn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%Y') AS Year FROM diaries WHERE user_id = $id ORDER BY Year");
          $stmt3->execute();
          $years = $stmt3->fetchAll();
            foreach ($years as $year) {
         
         
           echo '<option value="month-diaries.php?year='.$year['Year'].'&monthid='.$monthid.'"';

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
    <div class="last-diaries month-diaries">
      <a href="month-diaries.php?year=<?php echo $yearid ?>&monthid=<?php echo $monthid+1 ?>" class="next-month">Next Month <i class="fa fa-chevron-circle-right"></i></a>
      <a href="month-diaries.php?year=<?php echo $yearid ?>&monthid=<?php echo $monthid-1 ?>" class="previous-month"><i class="fa fa-chevron-circle-left"></i> Pervious Month</a>
      <div class="row">
        <?php
         $stmt = $conn->prepare("SELECT * FROM diaries WHERE DATE_FORMAT(date,'%Y') = $yearid AND DATE_FORMAT(date,'%m') = $monthid AND user_id = $id ORDER BY date DESC");
         $stmt->execute();
         $rows = $stmt->fetchAll();
          foreach ($rows as $row) {
             $dateYear = date("D , Y", strtotime($row['date']));
             $dayNumber = date("j<\s\u\p>S</\s\u\p>", strtotime($row['date']));
             $mounth = date("M", strtotime($row['date']));
        ?>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
          <a class="diary-visit-link" href="diary.php?diaryid=<?php echo $row['id']; ?>">
            <div class="diary-box text-center">
              <div class="card border-success mb-3">
                <div class="card-header"><?php echo $mounth  ?></div>
                <div class="card-body text-success">
                  <h3 class="diary-num-day"><?php echo $dayNumber  ?></h3>
                  <p class="diary-day"><?php echo $dateYear  ?></p>
                  <p class="calendar-icon"><i class="fas fa-calendar-alt"></i></p>
                </div>
              </div>
            </div>
            <span class="diary-pagination"></span>
          </a>
        </div>
        <?php  } ?>
        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
          <a class="diary-visit-link" href="diary.php?diaryid=<?php echo $row['id']; ?>">
            <div class="diary-box text-center">
              <div class="card border-success mb-3">
                <div class="card-header"><?php echo $monthShortName;  ?></div>
                <div class="card-body text-success">
                  <h3 class="diary-num-day"><a href="newdiary.php">New <i class="fas fa-plus"></i></a></h3>
                  <p class="diary-day"><?php echo date("d M , Y")  ?></p>
                  <p class="calendar-icon"><i class="fas fa-calendar-alt"></i></p>
                </div>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include $templates.'footer.php';
?>
