<?php
    session_start();
   
    require_once "../../libraries/database/pdo/db_connect.php";
    require_once "../class_models/department.php";
    require_once "../class_models/course.php";
    
    //variable declaration	
    $course_table = null;
    $db_connector=new DBConnector();
    $db_connector->connect();
    $dept = new IMDepartment($db_connector);

    $mode='add';
    $cc = null;
    $dpt = null;
    $title = null;
    $desc = null;
    $disabled = "";
    $ov = "";
    $ctype = 0;
    $instcourse_id = null;
    $start_date = null;
    $end_date = null;

//edit mode  
   if(isset($_POST['edit'])){
      $disabled = "disabled";
      $mode = "edit";
      $cc = $_POST['cc'];//course id
      $dpt = $_POST['deptid'];//department id
      $desc = $_POST['cdesc'];//course description
      $ov = $_POST['ov'];//course overview
      $ctype = $_POST['ctype'];//course type
      $instcourse_id = $_POST['instcourse_id'];//instructor course record id
      $start_date = $_POST['start_date'];
      $end_date = $_POST['end_date'];
  }


   /*---load all pages in this page----*/
  if (isset($_SESSION['inst_id'])){
    $course = new IMCourse($db_connector);
    $course_table = $course->getAllCourses();
    include "../template/header.php";
    include "components/add_course_form.php";

  }else{
    header("Location: ../../instructor_module/pages/login.php");
  }
?>
     </center>
   </body>
</html>
