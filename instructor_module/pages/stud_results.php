<?php
   session_start();

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
     $title = $_SESSION['title'];

     require_once "../../instructor_module/class_models/quiz_model.php";
     $qmod = new QuizModel();
     $test_inf = $qmod->getTest($_GET['tid']);
     $qrs = $qmod->getRs($_GET['tid']);
     
     include "../template/header.php";
     
     echo "<div class='content-container'>";
       include "../template/c_title.php";
       echo "<div class='c-nav-container'>";
          include "../template/side_bar.php";
	  include("components/stud_results_content.php");
       echo "</div>";
     echo "</div>";
   }
?>

 </center>
   </body>
</html>