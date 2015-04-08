<?php
  include "libraries/index_includes/index_head.php";  
  if(isset($_SESSION['scr_id']))
     unset($_SESSION['scr_id']);

?>

<body style="font-family: verdana" id="homeBody">
   <?php 

  include "libraries/index_includes/Course_Query.php";
  include "libraries/index_includes/CourseContents.php";
 
?>

<div id="accessB">
<ul class="nav nav-pills navbar-right btn-default">
  <li><a href="index.php" class="glyphicon glyphicon-home">Home</a></li>
  <li class="active"><a href="Courses.php" class="glyphicon glyphicon-briefcase">Courses </a></li>
  <li ><a href="login.php" class="glyphicon glyphicon-user">Login</a>
</ul>
</div>
