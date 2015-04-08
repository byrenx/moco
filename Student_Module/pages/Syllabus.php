<?php
  session_start();
  $topic_list = null;
if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
  include '../templates/header.php';

  include '../templates/c_title.php';
  include '../templates/side_bar.php';
  //establish database connection
  require_once "../../libraries/database/pdo/db_connect.php";
  $db_connector = new DBConnector();
  $db_connector->connect();

  //initialize syllabus  class
  include "../classes/sm_syllabus.php";
  $syllabus = new SM_Syllabus($db_connector);
  $topic_list = $syllabus->getAllSyllabus($_SESSION['scr_id']);
  //if(count($topic_list)>0)
  //print_r($topic_list);
  include '../components/syllabus_content.php';
 
}else{
 
}
?>