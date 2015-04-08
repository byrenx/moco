
  <!--class content -->
  <div id="about_cont_con">

  <!-- Header -->
  <div id="aboutOnline_hdr">
        <span id="aboutOnline_hdr_title" class="navbar navbar-inverse">
           About the Course
        </span>
  <span style="possition: absolute; left: 90%;">
  <!--description-->
  </br></br></br>
  <div id='sub-content' class='jumbotron'>
     <span>

     <span>
       <b> Course Starts: </b>
     </span>
     <span>
     
     <?php

     $Start = new DateTime($course_info['date_start']);
     $End = new DateTime($course_info['date_end']);
     $today = new DateTime();
        echo $Start->format('D,M d Y');

      ?>
     </span></br></br>
     <span>
       <b> Course Ends: </b>
     </span>
     <span>
	<?php echo $End->format('D, M d Y'); ?>
     </span></br></br>
       <b> Course Code: </b>
     </span>
     
     <span>
         <?php echo $course_info['course_id']; ?>
     </span>
     </br></br>
     <span>
       <b> Instructor: </b>
     </span>
     <span>
          <?php
             echo $course_info['LASTNAME'].", ".$course_info['FIRSTNAME'].
                  " ".$course_info['MIDDLENAME'];
          ?>
     </span></br></br></br>
     
    
     <span>
       <b> Course Overview </b>
     </span></br></br>
     <span>
          <?php
             echo $course_info['course_overview'];
          ?>
     </span>
     </br></br>
</br></br>
     <span> 
          <?php

     if(($today<=$End)&&($today>=$Start)){
       if(isset($_SESSION['stud_id'])&&isset($_SESSION['scr_id'])){
	 include "enroll_dialog.php";
	 include "enroll.php";
       }else{
     $sign = "../../login.php?";
           echo " <a href='$sign"."status=login&scrid={$_SESSION['scr_id']}&Cor_code={$course_info['course_id']}'".
	     "class='btn btn-primary'> Enroll Course </a>";}
     }else{
       echo "<a href='#' class='btn btn-danger disabled'> Un Available </a>"; 
     }
          ?>
     </span>
     </div>
  </div>
</div>