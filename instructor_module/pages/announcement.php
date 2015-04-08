<?php  
   session_start();

   //variable declaration
   $title=null;
   $anns = null;

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
      
      $title = $_SESSION['title'];

      include "../template/header.php";
      echo "<div class='content-container'>";
         include "../template/c_title.php";
	 echo "<div class='c-nav-container'>";
	   include "../template/side_bar.php";

      //establish database connection
      require_once "../../libraries/database/pdo/db_connect.php";
      $db_connector = new DBConnector();
      $db_connector->connect();

      //initialize announcement class
      include "../class_models/im_announcement.php";
      $announcement = new IM_Announcement($db_connector);
      $anns = $announcement->getAllAnnouncement($_SESSION['icr_id']);   
      
      //load page content
         include "components/ca_content.php";
      echo "</div>";
      include "components/add_announcement_diag.php";
   }else{
      //show error page
   }  
?>
     </center>
  </body>
</html>