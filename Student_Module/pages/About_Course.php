<?php 
ob_start();
session_start();
//Include directives
require_once "../../libraries/database/pdo/db_connect.php";
require_once "../classes/course.php";
//Page Variables
$course_info = NULL;
$db_connector = NULL;
$course = NULL;

//Quiz Redirector






  if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id'])){
     include "../templates/header.php";
    loadDB();
    loadContent();
   }else if(isset($_SESSION['stud_id']) && isset($_GET) && isset($_GET['scrid'])){
     $_SESSION['scr_id'] = $_GET['scrid'];//student courese record id
     include "../templates/header.php";
     loadDB();
     loadContent(); 
  }else if(isset($_SESSION['scr_id'])){
    include "../templates/index_head.php";
    loadDB();
    loadContent();
  }else if(isset($_GET['scrid'])){//Open Courseware Student
    include"../templates/index_head.php";
    $_SESSION['scr_id'] = $_GET['scrid'];
       loadDB();
       loadContent();
  }else{
     //show page not found error
     print '</br></br></br></b></br></br>';
     print 'Page not found Error!';
   } 

   //procedures
   function loadDB(){
     //establish database connection
     global $db_connector;

     $db_connector = new DBConnector();
     $db_connector->connect();//connect to db
   }   
   
   
   function loadContent(){
     global $db_connector, $course, $title_all;
     //initialize course class
     $course = new IMCourse($db_connector);
     //get Course Information
     $course_info = $course->getOnlineCourseInfo($_GET['scrid']);
     
      if($course_info){

        $title = $course_info['course_desc'];
        $_SESSION['Course_title'] = $title;
        
        include "../components/about_content.php";
     }else{
       //show error page 
	    header("Location: ../../Courses.php");
       //  exit();
	//   echo"error";
      }
   }