<?php
   session_start();
   //variable declaration
   $title=null;
   $anns = null;
   $action = "add";
   $title = $_SESSION['title'];
   $ann_id = null;
   $announcement = null;

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
     if(isset($_GET['action']) && $_GET['action']=='edit'){
        $action = 'edit';
	require_once "../class_models/im_announcement.php";
	$annClass = new IM_Announcement();
	if(isset($_GET['ann'])){
	  $ann_id = $_GET['ann'];
	  $announcement = $annClass->getAnnouncement($ann_id);
	}
      }

      include "../template/header.php";
      echo "<div class='content-container'>";
         include "../template/c_title.php";
	 echo "<div class='c-nav-container'>";
	   include "../template/side_bar.php";
	   include "../pages/components/addEditAnnouncement.php";
	 echo "</div>";
      echo "</div>";

   }else{
      //show error page
   }  
?>