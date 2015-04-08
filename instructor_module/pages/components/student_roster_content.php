<?php
require_once "../class_models/student_roster_model.php";

$student_roster = new IMStudentRoster();
$roster_list = array();
$filter = "all";
$ic_id = $_SESSION['icr_id'];
$studid = null;
$fname = null;
$lname = null;
$year = null;
$month = null;

if(count($_POST) > 0){
  $filter = $_POST['filter'];
  $ic_id = $_POST['ic_id'];
}

if ($filter=="all"){
  $roster_list = $student_roster->getAllStudent(array($ic_id));
}else if($filter=="studid"){
  $studid = $_POST['studid'];
  $roster_list = $student_roster->getStudentsbyID(array($ic_id, "%".$studid."%"));
}else if($filter=="fname"){
  $fname = $_POST['fname'];
  $roster_list = $student_roster->getStudentsbyFirstname(array("%".$fname."%", $ic_id));
}else if($filter=="lname"){
  $lname = $_POST['lname'];
  $roster_list = $student_roster->getStudentsbyLastname(array("%".$lname."%", $ic_id));
}else if($filter == "year"){
  $year = $_POST['year'];
  $roster_list = $student_roster->getStdentsbyYear(array($year, $ic_id));
}else if($filter == "monthyear"){
  $year = $_POST['year'];
  $month = $_POST['month'];
  $roster_list = $student_roster->getStudentsbyMonthYear(array($year, $month, $ic_id));
}

?>


<div id="about_cont_con">
   <div id="about_hdr">
     <span class="h3">
       Student Roster
     </span>
   </div>
   <div id="sub-content">
     <form action="student_roster.php" class="form-inline" method="POST">
       <input type="hidden" name="ic_id" value="<?php echo $ic_id;?>">
       <div class="form-group">
         <select id="stud_roster_filter" name="filter" class="form-control" onchange="changeFilter()">
           <option>----Filter by----</option>
           <option value="all" <?php if ($filter=="all") echo "selected=selected"?>>All</option>
           <option value="studid" <?php if ($filter=="studid") echo "selected=selected"?>>Student ID</option>
           <option value="fname" <?php if ($filter=="fname") echo "selected=selected"?>>Firstname</option>
           <option value="lname" <?php if ($filter=="lname") echo "selected=selected"?>>Lastname</option>
           <option value="year" <?php if ($filter=="year") echo "selected=selected"?>>Date Joined (Year)</option>
           <option value="monthyear" <?php if ($filter=="monthyear") echo "selected=selected"?>>Date Joined (Month-Year)</option>
         </select>
       </div>
       <div id="filter_input" class="form-group">
         <input type="text" class="form-control">
       </div>
      <button type="submit" class="btn btn-default">
        <span class="glyphicon glyphicon-search"></span>
      </button>
     </form>
     </br>
     <div class="col-sm-12"> 
  <?php if (isset($_GET['status'])){?>
       <p <?php if ($_GET['status']=='errd'){ 
                    echo "class='alert alert-danger'";
                }
	        if ($_GET['status']=='sd'){
                    echo "class='alert alert-success'";
                }
          ?>
        >
	  <?php if ($_GET['status']=='errd'){ echo "Unable to unenroll student with quiz, assignment, or exam records";?>
	  <?php }else{ echo "Selected student succesfully unenrolled";}?>
       </p>
  <?php }?>
       <?php if(!empty($roster_list)){?>
           <table class="table table-condensed table-striped">
             <thead>
               <th>ID Number</th>
               <th>Name</th>
               <th>Course</th>
               <th>Date Joined</th>
               <th>Action</th>
             </thead>
             <tbody>
               <?php foreach($roster_list as $student){?>
	            <?php $student_id = $student['IDNUMBER'];?>
		    <tr>
                        <td><?php echo $student['IDNUMBER']?></td>
			<td>
                           <form id="<?php echo $student_id;?>" action="student_profile.php" method="POST">
			      <input type="hidden" name="id" value="<?php echo $student['IDNUMBER'];?>">
			      <input type="hidden" name="ic_id" value="<?php echo $ic_id;?>">
                           <a style="cursor: pointer" onclick="$('#<?php echo $student_id;?>').submit()">
                                <?php echo $student['FIRSTNAME'].' '.$student['LASTNAME'];?></a>
                          </form>
                        </td>
                        <td><?php echo $student['COURSE']?></td>
			<td><?php echo $student['date_joined']?></td>			     			<td>
			    <form action="../../libraries/php/exec_controller.php" method="POST">
				<input type="hidden" name="action" value="del">
				<input type="hidden" name="target" value="student_course">
				<input type="hidden" name="scr_id" value="<?php echo $student['scr_id']?>">
			       <button type="submit" class="btn-link">
						       <span class="glyphicon glyphicon-remove"></span>&nbsp;Unenroll
                               </button>
			    </form>
                        </td>
                    </tr>
	       <?php }?> 
             </tbody>
           </table>
        <?php }?>
     </div>
   </div>
</div>

<script language="javascript">
		  $(document).ready(function(){changeFilter();});		  
</script>