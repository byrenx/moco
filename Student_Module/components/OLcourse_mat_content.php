<!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class='h3'>
	   Course Outline
	</span>
     </div>
    <div id='sub-content'>
   
 
      <div class="expandable">
         <?php 
   
   if($_SESSION['scr_id']){
       $_COURSE_MAT_VIEW->displayLectsAndMats($_SESSION['scr_id']);
   }
         ?>

      </div>
    </div>


