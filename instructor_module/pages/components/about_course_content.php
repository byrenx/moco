 
<!--- content--->
<div id="about_cont_con">
   <!--<div class="col-md-9 col-md-push-3">-->
   <!---header-->
   <div id="about_hdr">
   <span class='h3'>
   About the Course
   </span>
   <span style="position: absolute;left: 260px;top:5px;">
   <form action="add_course.php" method="post">
   <input type="hidden" name="cc" value="<?php echo $course_info['course_id']; ?>">
   <input type="hidden" name="cdesc" value="<?php echo $course_info['course_desc']; ?>">
   <input type="hidden" name="deptid" value="<?php echo $course_info['dept_id']; ?>">
   <input type="hidden" name="ov" value="<?php echo $course_info['course_overview']; ?>">
   <input type="hidden" name="ctype" value="<?php echo $course_info['course_type'];?>">
   <input type="hidden" name="instcourse_id" value="<?php echo $course_info['ic_id'];?>">
   <input type="hidden" name="start_date" value="<?php echo $course_info['date_start'];?>">
   <input type="hidden" name="end_date" value="<?php echo $course_info['date_end'];?>">
     
   <button class='btn btn-primary' name='edit' value='edit'>
   <span class="glyphicon glyphicon-edit"></span>
   Update
   </button>
   </form>
   </span>
		
   <!--description-->
   </div>
   <div id='sub-content'>
   <div class="col-sm-6">
   <h3>Course Code : </h3>
   <h3><small><?php echo $course_info['course_id']; ?></small></h3>

   <h3>Course Type</h3>
   <h3><small>
 <?php 
   if($course_info['course_type']==1){
     echo "Online Course ";
   }else{
     echo "Open Courseware ";
   }
?>
</small>
</h3>

</div>
<div class="col-sm-6">
   <?php if($course_info['course_type']==1){ ?>
					     <div class="col-sm-12 alert alert-info">
					     <span class="info-label">Course key:</span>
					     <span class="info-desc">
					     <?php echo $course_info['ck_key']; ?>
					     </span>
					     </div>
					     <?php }?>
</div>

<div class="col-sm-12">
   <hr/>
   <?php if ($course_info['course_overview']!=''){ ?>
						   <h3>Course Overview</h3>
						   <p>
						   <?php echo $course_info['course_overview'];?>
						   </p>
						   <?php }?>
</div>
        
</div> <!---end of sub content--->
</div>