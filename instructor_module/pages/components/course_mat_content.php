<script type="text/javascript">
   $(function(){
       $("#cm-con-accord").accordion();
     });
</script>

<!--- content --->
  <div id="about_cont_con">
     <!--- header --->
     <div id="about_hdr">
	<span class='h3'>
	   Course Materials
	</span>
     </div>
    <div id="sub-content">
      <?php
   if (isset($_GET['stat'])){
     $stat = $_GET['stat'];
     if ($stat==0){ 
       echo "<p class='alert alert-danger'><b>Upload Failed:</b>&nbsp;File size limit exceeded</p>";
     }
     
   }
      ?>
      </br>  
      <div class="expandable">
         <?php 
           $_COURSE_MAT_VIEW->displayLectsAndMats($_SESSION['icr_id']);
         ?>
      </div>
    </div>

