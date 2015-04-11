<?php
session_start();
   

if(isset($_SESSION['inst_id']) && isset($_SESSION['icr_id'])){
  $title = $_SESSION['title'];

  $action = (isset($_GET['action'])? $_GET['action']: null);
  $stat = (isset($_GET['stat'])? $_GET['stat']: null);
  $ass_id = (isset($_GET['ass_id'])? $_GET['ass_id']: null);

  include "../template/header.php";
  echo "<div class='content-container'>";
  include "../template/c_title.php";
  echo "<div class='c-nav-container'>";
  include "../template/side_bar.php";
  include "components/add_assignment_con.php";
  echo "</div>";
  echo "</div>";
}
?>
</center>
</body>
</html>
