
  <!--class content -->
  <div id="about_cont_con">

  <!-- Header -->
  <div id="about_hdr">
        <span id="about_hdr_title">
           About the Course
        </span>
  <span style="possition: absolute; left: 90%;">
  <!--description-->
  </br></br></br>
  <div id='sub-content'>
     <span>
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
     <?php  echo $course_info['LASTNAME'].", ".$course_info['FIRSTNAME'];
     $_SESSION['inst'] = $course_info['LASTNAME']; ?>
     </span>
     </br></br>
     <span>
       <b> Course Overview </b>
     </span></br></br>
     <span>
          <?php
             echo $course_info['course_overview'];
          ?>
     </span>
     </br></br></br></br>
     </div>
  </div>
</div>