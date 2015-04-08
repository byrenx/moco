<?php
  session_start();
  //Include directives
  require_once "../../libraries/database/pdo/db_connect.php";
  include "../classes/im_announcement.php";
//Variable declaration
 
  $ann = null;

if(isset($_SESSION['stud_id']) && isset($_SESSION['pcr_id'])){
  include '../templates/header.php';
  
  loadDB();
  loadContent();
  
  //establish database connection
} else if(isset($_SESSION['pcr_id'])){
  include "../templates/index_head.php";
  loadDB();
  loadContent();

} else{
  header("Location: ../../index.php");
  exit();
}

  function loadDB(){
    global $db_connector;
  $db_connector = new DBConnector();
  $db_connector->connect();

  }

function loadContent(){
  //initialize announcement class
  global $db_connector, $announcement;
  $announcement = new IM_Announcement($db_connector);
  $ann = $announcement->getAllOpenAnnouncement($_SESSION['pcr_id']);
  //load page content
  if(count($ann)>0){
     include "../templates/c_title.php";
     include "../templates/Open_Sidebar.php"; 
     include '../components/ca_content.php';
  }else{
     include "../templates/c_title.php";
     include "../templates/Open_Sidebar.php"; 
     echo "<div id='about_cont_con' class='jumbotron'> <h3> No Annoucements yet.</h3> <div>";
  }
}

  ?>
       </center>
  </body>
</html>
  
  