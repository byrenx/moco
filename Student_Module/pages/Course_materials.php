<?php
   session_start();
   
   $topic_list = NULL;

//Quiz Redirect



if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
  include '../templates/header.php';

  include '../templates/c_title.php';
  include '../templates/side_bar.php';
  require_once "../class_interface/course_mat_interface.php";
   //Establish Database connection
  $_COURSE_MAT_VIEW = new CoursematInterface();
   //initialize Course Materials  class
   
   //content
   include "../components/OLcourse_mat_content.php";
   
}else{


}
?>
 