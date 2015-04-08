<?php
   session_start();
   include '../../libraries/php/sanitizer.php';

   //remove session prevoiusly manage course
   if(isset($_SESSION['icr_id'])){
     unset($_SESSION['icr_id']); 
   }
   
   $instructor_pix=null;
   $instructor_name=null;

   $course_type=null;
   $course_list=null;

   if(isset($_SESSION['inst_id'])){
     
      include "../template/header.php";
      require_once "../class_models/im_instructor.php";
     
      //$instructor=new IM_Instructor($db_connector);
      $instructor=new IM_Instructor();
      
      if(isset($_GET['course']) && $_GET['course']=='oc'){//online course
          $course_list = $instructor->getOC($_SESSION['inst_id']);      
      }else if(isset($_GET['course']) && $_GET['course']=='ocw'){//open courseware
          $course_list = $instructor->getOCW($_SESSION['inst_id']);
      }else{
          $course_list = $instructor->getAllCourse($_SESSION['inst_id']);
      }
       
      if($course_list==null && !(isset($_GET['course']))){
	 include "components/fresh_start.php";
      }else{
	 include "components/cd_courses.php";
      }
   }else{//display page not found error message
        header("Location: ../../instructor_module/pages/login.php");
   }

   //footer
?>
    </center>
   </body>
</html>
