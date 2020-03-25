<?php


// Errors Reporting
ini_set('display_errors', 'On');
error_reporting(E_ERROR | E_WARNING | E_PARSE);


 include'connection.php';


 $sessionUser='';
 
 if (isset($_SESSION['user'])) {

	$sessionUser = $_SESSION['user'];
}
// routes

$templates="includes/templates/";//templates directory
$functions="includes/functions/";//functions directory
$css = 'themes/css/';//Css directory
$js = 'themes/js/';//Js directory

// Include the important files
 include $functions.'functions.php';
 include $templates.'header.php';
 

  







?>