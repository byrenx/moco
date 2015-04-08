<?php
  session_start();
  include '../../libraries/php/sanitizer.php';
  //remove previous session 
   if(isset($_SESSION['scr_id']))
     unset($_SESSION['scr_id']);
   if(isset($_SESSION['pcr_id']))
     unset($_SESSION['pcr_id']);
   
   require_once "../../libraries/database/pdo/db_connect.php";

   //variables
   //instantiate database connector
   $db_connector = new DBConnector();
   //connect to the database
   $db_connector->connect();
   $course_type=null;
   $offered_list=null;
   
  if(isset($_SESSION['stud_id'])){
  include "../templates/header.php";
  //include "../templates/moco_banner.php";
  //include "../components/cd_head.php";

  
   require_once "../classes/Student_Checker.php";
   $student = new Student_Checker($db_connector);
   $totalRows = $student->getMaxRows();
   
     $pageNum = 0;
     $maxRows = 9;
     $startRow = $pageNum * $maxRows;
     ?>

        
<?php

  
  if(isset($_GET['course']) && $_GET['course']=='online'){//Online Course
       $offered_list = $student->getOfferedOnline();
  }else if(isset($_GET['course']) && $_GET['course']=='open'){//Open Courseware
       $offered_list = $student->getOfferedOpen();
  }else if(isset($_GET['type']) && isset ($_GET['box']) && ($_GET['type'] == '1')){
    $offered_list = $student->searchCoursebyCode($_GET['box']);
   $checked = '';
  }else if(isset($_GET['type']) && isset ($_GET['box']) && ($_GET['type'] == '2')){
    $offered_list = $student->searchCoursebyDept($_GET['box']);
   $checked = '';
  }else if(isset($_GET['type']) && isset ($_GET['box']) && ($_GET['type'] == '3')){
    $offered_list = $student->searchCoursebyInst($_GET['box']);
   $checked = '';
 }else if(isset($_GET['type']) && isset ($_GET['box']) && ($_GET['type'] == '4')){
    $offered_list = $student->searchCoursebyTitle($_GET['box']);
   $checked = '';
  }else {
       $offered_list = $student->getAllCourses();     
  }       
  echo"  </ul>
       </div>";
  //include "components/cd_head.php";
  include "../components/cd_offered.php";
  
  }else{//display page not found error message
    header("Location: ../../login.php");
  }



?>

