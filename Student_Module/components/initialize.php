<?php
  
  include "../../libraries/php/sanitizer.php";
  include "../../libraries/database/pdo/db_connect.php";
  
  
  class Commit{
     private $connector;
     
     public function __construct(){
        $this->connector = new DBConnector();
        $this->connector->connect();
     }
  
     public function commitAction($action, $target){
        if($action=="add"){
           $this->commitAddAction($target);
        }
        if($action=="edit"){
          $this->commitUpdateAction($target);
        }  
        if($action=="login"){
	      $this->login();
        }    
     }

     private function commitAddAction($target){
        if($target == "course"){
          //echo "Add Course Redirected!";
          require_once "../../instructor_module/classes/course.php";
	      $course = new IMCourse($this->connector);
          $course->teachACourse(); 
	      header ("Location: ../../instructor_module/pages/course_dashboard.php");
        }else if($target=="announcement"){
          require_once "../../instructor_module/classes/im_announcement.php";
          $announcement = new IM_Announcement($this->connector);
          $announcement->addNewCourseAnnouncement();
        }
     }

     private function commitUpdateAction($target){
       if($target=="course"){
         require_once '../../instructor_module/classes/course.php';
         require_once '../../instructor_module/classes/im_instructor.php';
         $instructor = new IM_Instructor($this->connector);
         $course = new IMCourse($this->connector);

         $instructor->updateTeachCourse();
         $course->updateCourse();       
         header ("Location: ../../instructor_module/pages/course_dashboard.php");
       }else if($target=="announcement"){
         require_once '../../instructor_module/classes/im_announcement.php';
         $announcement = new IM_Announcement($this->connector);
         
         $announcement->updateAnnouncementPanel();
       }
     }

     private function login(){
       require_once '../../libraries/proj_abs_cls/account.php';
       $account = new Account($this->connector);
       $account->validatingAccess();
     }

    
  }

  $commit = new Commit();
 
  if(count($_POST) > 0){
     $commit->commitAction($_POST['action'], $_POST['target']);       
  }else if(count($_GET)>0){  
     $commit->commitAction($_GET['action'], $_GET['target']);
  }


?>
