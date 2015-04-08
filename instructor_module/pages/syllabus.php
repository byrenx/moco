<?php
   session_start();

   if(isset($_SESSION['icr_id']) && isset($_SESSION['inst_id'])){
     
     require_once '../class_models/im_syllabus.php';
     
     //declaring chapter object
     $syllabus = new IMSyllabus();
     $chapters = $syllabus->getAllChapters($_SESSION['icr_id']);
     $title = $_SESSION['title'];

     include("../template/header.php");
     //title
     echo "<div class='content-container'>";
        include "../template/c_title.php";
	echo "<div class='c-nav-container'>";
          //side banner
          include "../template/side_bar.php";
          //content
          include("components/syllabus_content.php");  
     echo "</div>";
   }else{
     //page redirection
     echo "<b>Error 404</b> - Page does not Exist";
   }
  
   
?>

 </center>
   </body>
</html>