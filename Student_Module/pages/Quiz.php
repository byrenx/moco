<?php
 session_start();
   $title = null;

   if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
     require_once '../../Student_Module/class_interface/quiz_interface.php';
     $quiz_intrfc = new QuizInterface(); 
     include "../templates/header.php";
     include "../templates/c_title.php";
     include "../templates/side_bar.php";
     
     include "../components/quiz_list.php";
    
   

   }


?>
    
</center>
</body>
</html>