
<!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class="h3">
           Assignments
	</span>
     </div>
    <div id='sub-content'>
      <!----add item form--->
     

     <div style='position: relative; top: 30px; background: rgba(0,0,0,.1)'>

   <?php
       require_once "../class_interface/assignment_interface.php";
      $ass_int = new AssignmentInterface();
      $ass_int->displayAssignments($_SESSION['scr_id']);
   ?>
     </div>
    </div>
  </div><!---end of container---->

