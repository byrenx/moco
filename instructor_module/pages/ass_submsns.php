<?php
   session_start();

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
     $title = $_SESSION['title'];

     require_once "../../instructor_module/class_models/assignment_model.php";
     $ass_mod = new AssignmentModel();
     $ass_mod->connect_to_db();
     $ass_inf = $ass_mod->get_ass($_GET['ass_id']);//assignment info
     $ass_subs = $ass_mod->getSubmsns($_GET['ass_id']);//submissions
     
     include "../template/header.php";
     
     echo "<div class='content-container'>";
       include "../template/c_title.php";
       echo "<div class='c-nav-container'>";
          include "../template/side_bar.php";
	  include("components/ass_submsns_list.php");
       echo "</div>";
     echo "</div>";
   }
?>

 </center>
   <?php include "components/rate_ass_frm.php";?> 
   </body>
</html>