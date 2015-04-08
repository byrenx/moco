<?php
  ob_start();
  session_start();  
  
  //Incude directives
  require_once "../../libraries/database/pdo/db_connect.php";
  require_once "../classes/course.php";


  //page variables
  $title = NULL;
  $course_info = NULL;
  $db_connector = NULL;
  $course = NULL;

  // page Content
 

  if(isset($_SESSION['stud_id']) && isset($_SESSION['pcr_id'])){
     include "../templates/header.php";
    loadDB();
    loadContent();
   }else if(isset($_SESSION['stud_id']) && isset($_GET) && isset($_GET['opcrid'])){
     $_SESSION['pcr_id'] = $_GET['opcrid'];//student courese record id
     include "../templates/header.php";
     loadDB();
     loadContent(); 
  }else if(isset($_SESSION['pcr_id'])){
    include "../templates/index_head.php";
    loadDB();
    loadContent();
  }else if(isset($_GET) && isset($_GET['opcrid'])){//Open Courseware Student
    include"../templates/index_head.php";
    $_SESSION['pcr_id'] = $_GET['opcrid'];
    unset($_SESSION['scr_id']);
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
require_once "../classes/course.php";
     $course = new IMCourse($db_connector);
     //get Course Information
     $course_info = $course->getOpenCourseInfo($_SESSION['pcr_id']);
     //print_r($course_info);
     //if($course_info){

        $title = $course_info['course_desc'];

        $_SESSION['Course_title'] = $title;
        
        include "../templates/c_title.php";
        include "../templates/Open_Sidebar.php";
        include "../components/class_content.php";
	//}else{
       //show error page 
	//  header("Location: ../../courses.php");
	//  exit();
	//  }
   }
   

?>
  </center>
   </body>
</html>