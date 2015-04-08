<div class='container'> 
  <?php include "../template/content_header.php";?>
  <div id='dashboard-disp-opt'>
    <div style='position:absolute;top:0px;left: 0px;'>
      <label>
      <?php
         $checked = '';
         if(!isset($_GET['course']) || (isset($_GET['course'])&&$_GET['course']=='all'))
            $checked='checked';
      ?>
       <input type='radio' name='ctype' checked='true' value='All'
              onclick="javascript:loadInstCourse('all');"
              checked="<?php echo $checked; ?>">
       All Courses
      </label>
    </div>

    <div  style='position:absolute;top:0px;left: 150px;'>
      <label>
        <?php
         $checked = '';
         if(isset($_GET['course']) && $_GET['course']=='oc')
            $checked='checked';
        ?>
        <input type='radio' name='ctype' value='Online Course'
               onclick="javascript:loadInstCourse('oc')"
	   <?php echo $checked; ?>
               >
        Online Course
      </label>
    </div>
    <div  style='position:absolute;top:0px;left: 315px;'>
      <label>
       <?php
          $checked = '';
          if(isset($_GET['course']) && $_GET['course']=='ocw')
            $checked='checked';
        ?>
        <input type="radio" name="ctype" value="OpenCourseware"
               onclick="javascript:loadInstCourse('ocw')"
	    <?php echo $checked; ?>
               >
        Open Courseware
      </label>
    </div>
    <div style="position: absolute;top:0px;left: 85%;">
	<a href="add_course.php" class="btn btn-primary">
	   <span class="glyphicon glyphicon-plus-sign"></span>
 	   Add Course
	</a>
    </div>
    </br>
  </div>

  <div id="cl_container">
    
   
   <!--course list-->
   <div>
    <?php if($course_list!=null){ ?>	    
	<table class="table table-hover">
	   <tr class='alert alert-info'>
	   <th>Course Code</th>
	   <th>Course Title</th>
	   <th></th>
	   </tr>
	   <?php
            
	   $link = "about_course.php?";
             
	   foreach($course_list as $course){
	     echo "<tr>";
	     echo "<td width='130px'>{$course['course_id']}</td>";//course id
	     echo "<td><a href='$link"."icrid={$course['ic_id']}"."'>{$course['course_desc']}</a></td>";//title
	     echo "<td width='80px'>";
	     echo "</td>";
	     echo "</tr>";
	   }//end of foreach
         ?>
        </table>
       <?php }else{?>
	</br>
	  <?php if($_GET['course']=='oc'){
	echo "<h3>No Online Courses Found!</h3>";
	echo "<h4>To add new course just click the 'Add Course' button</h4>";
	        }else if($_GET['course']=='ocw'){
	echo "<h3>No Open Courseware Found!</h3>";
	echo "<h4>To add new course just click the 'Add Course' button</h4>";
                }else{
	echo "<h3>No Courses Found!</h3>";
	echo "<h4>To add new course just click the 'Add Course' button</h4>";
                }
	  ?>
    <?php } ?>

     </div>
     </br>
     </br>
     </br>
   </div>
</div>
