<?php
   session_start();
   
//variables 
$action = 'add';
$target = 'quiz';
$ttype  = 0;
$test_id = null;
$q_title = null;
$title = null;
$date_avail = null;
$date_due = null;
$duration = null;

$get_action = (isset($_GET['action'])? $_GET['action']:  null);
$get_status = (isset($_GET['status'])? $_GET['status']:  null);

   if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
     $title = $_SESSION['title'];

     if(isset($_POST['action']) && $_POST['action']=='edit'){
       $action = 'edit';
       $test_id = $_POST['test_id'];
       $q_title = $_POST['title'];
       $date_avail = $_POST['da'];
       $date_due = $_POST['dd'];
       $duration = $_POST['duration'];
     }

     include "../template/header.php";
     echo "<div class='content-container'>";
        include "../template/c_title.php";
	echo "<div class='c-nav-container'>";
          include "../template/side_bar.php";
	  include "components/add_quiz_page.php";
	echo "</div>";
     echo "</div>";
   }
?>
     </center>
   </body>
</html>
