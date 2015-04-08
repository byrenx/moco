<?php
   $links=array(array("lbl"=>"About the Course","url"=>"../pages/Open_Course.php"),
		array("lbl"=>"Announcement","url"=>"../pages/Open_Announcement.php"),
		
	
		array("lbl"=>"Course Materials","url"=>"../pages/Open_Materials.php"),
                );
			
?>
<nav id="sbar_con"> 
 <ul class="nav nav-pills nav-stacked">
  <?php
     
     foreach($links as $lnk){
     // echo "<div id='side_menu'>";
     // echo "<span id='side_menu_link'>";
       echo "<li class='course-menu-item'>";
       echo "<a id='sideBar' style='padding:10px 0px 10px 25px;
                       min-heighr: 10px;
                       border: 1px solid rgb(226,226,226);' 
                       class='list-group-item'
              href='".$lnk['url']."'>";
	echo $lnk['lbl'];
       echo "</a>";
       //echo "</span>";
       //echo "</div>";
       echo "</li>";
     }
  ?>
</nav>