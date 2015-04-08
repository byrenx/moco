<?php
  session_start();  

  //Incude directives
  require_once "../../libraries/database/pdo/db_connect.php";
  require_once "../classes/course.php";

//Quiz Redirect



  //page variables
  $title = NULL;
  $course_info = NULL;
  $db_connector = NULL;
  $course = NULL;

  // page Content
  include "../templates/header.php"; 

if(isset($_SESSION['stud_id']) && isset($_SESSION['scr_id']) && isset($_SESSION['studC_id'])){
    loadDB();
    loadContent();
  }else if(isset($_SESSION['stud_id']) && isset($_GET) && isset($_GET['scrid'])&& isset($_GET['studC'])){
     $_SESSION['scr_id'] = $_GET['scrid'];//student courese record id
     $_SESSION['studC_id'] = $_GET['studC'];
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
     $course_info = $course->getCourseInfo($_SESSION['scr_id']);

     if($course_info){

        $title = $course_info['course_desc'];
        $_SESSION['Course_title'] = $title;
       
        include "../templates/c_title.php";
        include "../templates/side_bar.php";
        include "../components/class_content.php";
     }else{
       //show error page 
       print "Course not Found";
     }
    
   }
   

?>
  </center>
   </body>
</html>