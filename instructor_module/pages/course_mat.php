<?php
   session_start();

   if(isset($_SESSION['icr_id']) && isset($_SESSION['inst_id'])){
     
      require_once '../class_interface/course_mat_interface.php';

      $title = $_SESSION['title'];
     
      $_COURSE_MAT_VIEW = new CoursematInterface(); 
      //header
      include "../template/header.php"; 
      //title
      echo "<div class='content-container'>";
         include "../template/c_title.php";
         //side banner
	 echo "<div class='c-nav-container'>";
            include "../template/side_bar.php";
            //content
            include "components/course_mat_content.php";
         echo "</div>";
	 echo "</div>";
      /*****pop up dialogs*********/
      //add lecture
      include "components/add_lecture.php"; 
      //add lecture material
      include "components/add_lect_mat.php";
      //footer
   }
?> 
      
     </center>
   </body>

  <script language="javascript">

     $("#lect_mat_file").bind('change', 
			      function(){
				var max_file_size = 125; //125MB
				var file_size = Math.round(this.files[0].size/1024/1024);
				var msg = "";
				if (file_size>max_file_size){
				  msg = "<p> File Size: <span class='text-danger'>" + file_size + "&nbsp;MB</span>";
				}else{
				  msg = "<p> File Size: <span class='text-success'>"+file_size + " MB</span></p>";
				}
				$("#f_size").html(msg);
			      });
     
  </script>
</html>