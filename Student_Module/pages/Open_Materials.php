<?php
   session_start();
   $topic_list = NULL;

if(isset($_SESSION['stud_id']) && isset($_SESSION['pcr_id'])){
  include '../templates/header.php';
  loadContent();
}else if(isset($_SESSION['pcr_id'])){
  include '../templates/index_head.php';
  loadContent();
  }



function loadContent(){
  include '../templates/c_title.php';
  include '../templates/Open_Sidebar.php';
  require_once "../class_interface/course_mat_interface.php";
   //Establish Database connection
  $_COURSE_MAT_VIEW = new CoursematInterface();
   //initialize Course Materials  class
   
   //content
   include "../components/course_mat_content.php";
}

?>
 