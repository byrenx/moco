<?php
   session_start();
   $title = null;

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
     $title = $_SESSION['title'];
     //require_once '../../instructor_module/class_interface/quiz_interface.php';
     //$quiz_intrfc = new QuizInterface(); 
     include "../template/header.php";
     echo "<div class='content-container'>";
        include "../template/c_title.php";
	echo "<div class='c-nav-container'>";
          include "../template/side_bar.php";
          include "components/student_profile.php";
	echo "</div>";
     echo "</div>";
     //add quiz popup dialog
   }
?>
     </center>
   </body>
</html>
