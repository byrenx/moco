<div id="cl_container_stud">
   <!--header-->
   <div class="navbar navbar-inverse">

      <div class='navbar-header'>
	    <span id='c_title_header'>  Enrolled Courses </span>
      </div>
   </div>
   
   <!--course list-->
   <div>
     <table class="table table-hover">
		<tr class="alert alert-info">
            <th>Course Code</th>
            <th>Course Title</th>
	    <th>Instructor </th>
	   <!-- <th>Date Joined </th> -->
	    <th>Course Ends </th>
            <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
        </tr>
	    <?php
    //$courses = $_SESSION['courses'];
   if(isset($_GET['Action'])&&$_GET['Action']=='Error'){
   echo "<div class='panel-danger'>";
   echo "You can no longer un enroll this course because of the Ff:
         ";
   echo "</div>";
   }
   $link = "Goto_class.php?";
   
    foreach($enrolled_list as $course){
      $End = new DateTime ($course['date_end']);
      //   $DJoined = new DateTime ($course['date_joined']);
      echo "<tr>";
      echo "<td>".$course['course_id']."</td>";
      echo "<td>".$course['course_desc']; echo "</td>";
       echo "<td>".$course['LASTNAME'].", ".$course['FIRSTNAME']; echo "</td>";
       //echo "<td>{$DJoined->format('D,M d Y')}</td>";
      echo "<td>{$End->format('D,M d Y')}</td>";echo "<td>"; echo "</td>";echo "<td>";echo "</td>";
			   
      echo "<td>";
      echo "</td>";
      echo "<td style='width:100px'>";
      echo "<a href='$link"."scrid={$course['ic_id']}&&studC={$course['scr_id']}"."' class='btn btn-success''><span class='glyphicon glyphicon glyphicon-tasks'></span> Go to Class</a>";
      /*echo "</td>";
  echo "<td  style='width:100px'>";
     include "Unenroll.php";
  echo "</td>";
  echo "<td>";
     include "Unenroll_dialog.php";
     echo "<td>";
      */
      
      /*
      echo "<form action='../../libraries/php/executeAction.php' method='post'>
            <input type='hidden' name='std_id' value='{$_SESSION['stud_id']}'>
            <input type='hidden' name='scr_id' value='{$course['ic_id']}'>
            <input type='hidden' name='action' value='Unenroll'>
            <input type='submit' name'UnEnroll' value='Unenroll' class='btn btn-default''>";*/
		   //../pages/about_course.php
		    }
		  
		?>
	 </table>
   
   </div>
</div>





