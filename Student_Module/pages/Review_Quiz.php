<?php 
session_start();
$title = null;
$testID = NULL;
$type = NULL;
$totalP = NULL;
if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
  require_once '../../Student_Module/classes/sm_takeQ.php';
  $QuizStart = new TakeQuizInterface();
  include "../templates/header.php";
  include "../templates/c_title.php";
  echo "<center>";
  include "../components/Review_Now.php";
  // echo $_SESSION['item_id'];
  echo "</center>";
}
else{
  echo "Page not found!";
}