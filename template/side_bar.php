<?php
   $links=array(array("lbl"=>"About the Course","url"=>"../pages/about_course.php"),
		array("lbl"=>"Announcement","url"=>"../pages/announcement.php"),
                array("lbl"=>"Syllabus","url"=>"../pages/syllabus.php"),
		array("lbl"=>"Course Materials","url"=>"../pages/course_mat.php"),
		array("lbl"=>"Quiz","url"=>"../pages/quiz.php"),
		array("lbl"=>"Assignment","url"=>"#"),
		array("lbl"=>"Exam","url"=>"#"),
		array("lbl"=>"Student Results","url"=>"../pages/stud_results.php")
                );
			
?>

<div id="sbar_con"> 
  <ul class="course-side-menu">
  <?php
     
     foreach($links as $lnk){
     // echo "<div id='side_menu'>";
     // echo "<span id='side_menu_link'>";
       echo "<li class='course-menu-item'>";
       echo "<a href='".$lnk['url']."'>";
	echo $lnk['lbl'];
       echo "</a>";
       //echo "</span>";
       //echo "</div>";
       echo "</li>";
     }
  ?>
</div>