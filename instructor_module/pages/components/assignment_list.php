<!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class="h3">
           Assignments
	</span>
        <span style='position: absolute;
                     left: 190px;
                     top: 5px;'>
             <form action="add_assignment.php" method="post">
                 <button type='submit' class='btn btn-primary'>
                    <span class='glyphicon glyphicon-plus-sign'></span>
                    Add Assignment
                 </button>
             </form>
        </span>
     </div>
    <div id='sub-content'>
     <div style='position: relative; top: 20px;'>

   <?php
       require_once "../class_interface/assignment_interface.php";
      $ass_int = new AssignmentInterface();
      $ass_int->displayAssignments($_SESSION['icr_id']);
   ?>
      </br>
      </br>
      </br>
      </br>
     </div>
   </div>
</div>

  </div><!---end of container---->

