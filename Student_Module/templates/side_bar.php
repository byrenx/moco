<?php
   $links=array(array("lbl"=>"About the Course","url"=>"../pages/Goto_class.php"),
		array("lbl"=>"Announcement","url"=>"../pages/Announcement.php"),
		
		//array("lbl"=>"Syllabus","url"=>"../pages/syllabus.php"),
		array("lbl"=>"Course Outline","url"=>"../pages/Course_materials.php"),	array("lbl"=>"Quiz","url"=>"../pages/Quiz.php"),
		array("lbl"=>"Assignment","url"=>"../pages/Assignment.php"),
		array("lbl"=>"Exam","url"=>"../pages/Exam.php"),
                );
			
?>
<nav id="sbar_con"> 
 <ul class="nav nav-pills nav-stacked">
  <?php
     
     foreach($links as $lnk){
     // echo "<div id='side_menu'>";
     // echo "<span id='side_menu_link'>";
       echo "<li>";
       echo "<a  id='sideBar'  class='list-group-item'  href='".$lnk['url']."'>";
	echo $lnk['lbl'];
       if($lnk['lbl']=="Quiz"){
	 require_once '../../Student_Module/class_interface/quiz_interface.php';
	 $Qbadge = new QuizInterface();
	 $Qbadge->showQBadge($_SESSION['scr_id']);
 echo "</a>";
	  }
       if($lnk['lbl']=="Exam"){
	 require_once '../../Student_Module/class_interface/quiz_interface.php';
	 $Qbadge = new QuizInterface();
	 $Qbadge->showEBadge($_SESSION['scr_id']);
 echo "</a>";
       }
       if($lnk['lbl']=="Assignment"){
	 require_once '../../Student_Module/class_interface/assignment_interface.php';
	 $Abadge = new AssignmentInterface();
	 $Abadge->showABadge($_SESSION['scr_id']);
	 $Abadge->notify_rating($_SESSION['scr_id']);
       }else
       echo "</a>";
       //echo "</span>";
       //echo "</div>";
       echo "</li>";
     }
  ?>
</nav>