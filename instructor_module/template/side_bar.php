<?php
   $links=array(array("lbl"=>"About the Course","url"=>"../pages/about_course.php"),
                array("lbl"=>"Announcement","url"=>"../pages/announcement.php"),
		array("lbl"=>"Student Roster", "url"=>"../pages/student_roster.php"),
                array("lbl"=>"Course Outline","url"=>"../pages/syllabus.php"),
                array("lbl"=>"Course Materials","url"=>"../pages/course_mat.php"),
                array("lbl"=>"Quiz","url"=>"../pages/quiz.php"),
                array("lbl"=>"Assignment","url"=>"../pages/assignment_page.php"),
                array("lbl"=>"Exam","url"=>"../pages/exam.php")
                );
			
?>

<div id="sbar_con">
  <ul class="nav nav-pills nav-stacked">
     
  <?php
     
     foreach($links as $lnk){
       echo "<li class='course-menu-item'>";
       echo "<a href='".$lnk['url']."'>";
       echo $lnk['lbl'];
       echo "</a>";
       echo "</li>";
     }
  ?>
  </ul>
</div>
