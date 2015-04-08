
<center>
<div id="cl_Courses_container">
   <!--header-->
   <div class="navbar navbar-default" role="navigation">
     <span id="cl_head_title" class="navbar-header">
	    Offered Courses
	 </span>
   </div>
   <div id='dashboard-disp-opt'>
   <div style='position:absolute;top:0px;left:0px'>
   <label>
   <?php

   if(isset($_GET['course']) && $_GET['course']=='online'){//Online Course
       $offered_list = $student->getOfferedOnline();
}else if(isset($_GET['course']) && $_GET['course']=='open'){//Open Courseware
       $offered_list = $student->getOfferedOpen();
     }else {
       $offered_list = $student->getOfferedCourses();
     }
         $checked = '';
         if(!isset($_GET['course']) || (isset($_GET)&&$_GET['course']=='all'))
            $checked='checked';
      ?>
       <input type='radio' name='ctype' checked='true' value='All'
              onclick="javascript:loadOfferedCourses('all');"
              checked="<?php echo $checked; ?>">
       All
      </label>
    </div>

    <div  style='position:absolute;top:0px;left: 50px;'>
      <label>
        <?php
         $checked = '';
         if(isset($_GET['course']) && $_GET['course']=='online')
            $checked='checked';
        ?>
        <input type='radio' name='ctype' value='Online Course'
               onclick="javascript:loadOfferedCourses('online')"
	   <?php echo $checked; ?>
               >
        Online Course
      </label>
    </div>
    <div  style='position:absolute;top:0px;left: 215px;'>
      <label>
       <?php
          $checked = '';
if(isset($_GET['course']) && $_GET['course']=='open')
            $checked='checked';
        ?>
        <input type="radio" name="ctype" value="OpenCourseware"
               onclick="javascript:loadOfferedCourses('open')"
	    <?php echo $checked; ?>
               >
        Open Courseware
      </label>
    </div>
    </br>
  </div>
   

   <!--course list-->
   <div>
     <table class="table talbe-hover">
	 <tr class="success">
		 <th> Course Code </th>
		 <th> Course Title </th>
		 <th> Instructor </th>
		 <th> Course Type </th>
		 <th> Start Date </th>
                 <th>      </th>
                 <th>      </th> <th>      </th>                 <th>      </th>
                 <th>      </th>
     </tr> 
    </div>
    <div> 
	    <?php

function loadInfo(){
    global $offered;

    echo "<td>".$offered['course_id']."</td>";

    
	  }
		    //$courses = $_SESSION['courses'];
   $link = "Student_Module/pages/Open_Course.php?";
   $about = "Student_Module/pages/About_Course.php?";
   $sign = "login.php?";

foreach($offered_list as $offered){
  $Start = new DateTime($offered['date_start']);
  $End = new DateTime($offered['date_end']);
  $today = new DateTime();
  echo "<tr>";
  
  if($offered['course_type']==1){
    loadInfo();
    echo "<td> <a href='$about"."scrid={$offered['ic_id']}' title='Click to View About this Course'>"
      .$offered['course_desc']."</a></td>";
    echo "<td>".$offered['LASTNAME'].', '.$offered['FIRSTNAME'].' '.$offered['MIDDLENAME']."</td>";
    echo "<td> Online Course </td>";
    echo "<td>".$Start->format('D,M d Y')."</td>";
    echo "<td> </td>";
    if(($today<=$End)&&($today>=$Start)){
      echo "<td>"; 
      echo "<a href='$sign"."status=login&scrid={$offered['ic_id']}&Cor_code={$offered['course_id']}'"."class='btn btn-primary'><span class='glyphicon glyphicon-log-in'></span> Enroll Course </a>";
      echo"</td>";
    }else{
      echo "<td><a href='#' class='btn btn-danger disabled'><span class=' glyphicon glyphicon-warning-sign'></span> Un Available </a></td>";
    }
  }else if($offered['course_type']==2){
    loadInfo();
    echo "<td> <a href='$link"."opcrid={$offered['ic_id']}' title='Click to View this Course'>"
      .$offered['course_desc']."</a></td>";
    echo "<td>".$offered['LASTNAME'].', '.$offered['FIRSTNAME'].' '.$offered['MIDDLENAME']."</td>";
    echo "<td> Open and Online Course</td>";
    echo "<td>".$Start->format('D,M d Y')."</td>";
    echo "<td> </td>";
    if(($today<=$End)&&($today>=$Start)){
      echo "<td>"; 
      echo "<a href='$sign"."status=login&scrid={$offered['ic_id']}&Cor_code={$offered['course_id']}'"."class='btn btn-primary'><span class='glyphicon glyphicon-log-in'></span> Enroll Course </a>";
      echo"</td>";
    }else{
      echo "<td><a href='#' class='btn btn-danger disabled'><span class=' glyphicon glyphicon-warning-sign'></span> Un Available </a></td>";
    }
  }else
    {
      loadInfo();
      echo "<td>".$offered['course_desc']."</td>";
      echo "<td>".$offered['LASTNAME'].', '.$offered['FIRSTNAME'].' '.$offered['MIDDLENAME']."</td>";
      echo "<td> Open Courseware </td>";
      echo "<td></td>";
      echo "<td> </td>";
      $_SESSION['Open_Courseware'] = 0;
      echo "<td>"; 
      echo "<a href='$link"."opcrid={$offered['ic_id']}"."' class='btn btn-default''>
     <span class=' glyphicon glyphicon-eye-open'></span> View Course</a>";
      echo "</td>";
    }
  
  //../pages/about_course.php
  echo "</td>";
  echo "</tr>";
  echo "</tbody>";
  
  }

?>
</table>
</div>

</div>
</center>