<?php
   session_start();

   if(isset($_SESSION['icr_id']) && isset($_SESSION['inst_id'])){
      //title
     if(isset($_GET) && isset($_GET['id'])){

       $title = $_SESSION['title'];
       $test_id = $_GET['id'];
       //header
       include "../template/header.php"; 
        //title
       echo "<div class='content-container'>";
         include "../template/c_title.php";
	 echo "<div class='c-nav-container'>";
              include "../template/side_bar.php";
	       //side banner
         
       require_once "../../instructor_module/class_interface/quiz_interface.php";
       $quiz_interface = new QuizInterface();
       $quiz_info = $quiz_interface->getTestInfo($_GET['id']);
       
       if($quiz_info){
         $quiz_title = $quiz_info['title'];
          //content
          include "components/quiz_item_list.php";
          //footer
       }
       echo "</div>";
       echo "</div>";
     }
   }
?>

<!----background for popups----->
<div id="popup_background"></div>