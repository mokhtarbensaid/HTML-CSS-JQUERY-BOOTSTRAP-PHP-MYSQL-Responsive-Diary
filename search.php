<?php
session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
include 'initial.php';
include $templates.'navbar.php';
 $id = $_SESSION['uid'];

if (isset($_POST['submit1'])) {
  $search = $_POST['search'];
  $searchMonth  = $_POST['month'];
  $searchYear   = $_POST['year'];

}
if (isset($_POST['submit2'])) {
  $search = $_POST['search'];
  $searchMonth  = $_POST['month'];
  $searchYear   = $_POST['year'];

}
if (isset($_POST['submit3'])) {
  $search = $_POST['search'];
  $searchMonth  = $_POST['month'];
  $searchYear   = $_POST['year'];
  
}
?>
<div class="search">
  <h1 class="custom-title text-center">Search Results</h1>      
  <div class="container">
    <div class="search-box">
      <select class="form-control year">
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
    <div class="search-results">
    <ul class="list-unstyled">
      <?php

      if (!empty($searchMonth) && !empty($searchYear)) {
        $stmt = $conn->prepare("SELECT * FROM diaries WHERE (content LIKE '%$search%' OR title LIKE '%$search%') AND ( (DATE_FORMAT(date,'%M') = '$searchMonth' AND DATE_FORMAT(date,'%Y') = '$searchYear' ) AND user_id = '$id' )");
      }
     
      elseif (empty($searchMonth) && empty($searchYear)) {
        $stmt = $conn->prepare("SELECT * FROM diaries WHERE (content LIKE '%$search%' OR title LIKE '%$search%') AND user_id = '$id'");
      
      }elseif (empty($searchMonth) && !empty($searchYear)) {
        $stmt = $conn->prepare("SELECT * FROM diaries WHERE (content LIKE '%$search%' OR title LIKE '%$search%') AND user_id = '$id' AND DATE_FORMAT(date,'%Y') = '$searchYear'");
      
      }elseif (!empty($searchMonth) && empty($searchYear)) {
        $stmt = $conn->prepare("SELECT * FROM diaries WHERE (content LIKE '%$search%' OR title LIKE '%$search%') AND user_id = '$id' AND DATE_FORMAT(date,'%M') = '$searchMonth'");
     
      }
      $stmt->execute();
      $rows = $stmt->fetchAll();
      $count = $stmt->rowCount(); 
      
      if ($count>0) {
      echo '<p><b>'.$count.' Results</b></p>';
        foreach ($rows as $row) {
          $date = date("M d, Y", strtotime($row['date']));
        echo '<li class="alert alert-success"><h5>Diaries/ '.$date.'/ <a href="diary.php?diaryid='.$row['id'].'">'.highlight_word($row['title'], $search).'</a></h5><p>'.highlight_word($row['content'], $search).'</p></li>';
        }
      }else{
        echo '<li class="alert alert-danger">Sorry No Result! Choose other Word</li>';
      }
      ?>    
    </ul>
    </div>
  </div>
</div>
<?php

include $templates.'footer.php';
?>
