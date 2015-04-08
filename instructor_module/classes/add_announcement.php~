<?php
require_once "../../libraries/database/pdo/db_connect.php";
include "../../libraries/php/sanitizer.php";
  
$connect = new DBConnector();
$connect->connect();

$icr_id = sanitize($_POST['icr_id']);//instructor course record id
$ann_stmt = sanitize($_POST['ann_stmt']);


if($_POST['mode']=='add'){

  $query = "INSERT INTO announcement(ic_id, ann_stmt)
            VALUES(?,?)";

  if($connect->insert($query, array($icr_id, $ann_stmt)))
    loadAnn();   
  
  
}else{
  $ann_id = $_POST['ann_id'];
  $query = "UPDATE announcement SET
            ann_stmt=?
            WHERE ann_id=?
            ";
  if($connect->update($query, array($ann_stmt, $ann_id))){
  
  }
    
}

function loadAnn(){
  global $connect,$icr_id,$ann_stmt,$today;

  $query = "SELECT * FROM announcement
           WHERE ann_id=(SELECT MAX(ann_id)
                         FROM announcement)";
  $ann = null;

  if($ann=$connect->selectAll($query)->fetch()){
    
    print "<div id='ca_ann_con' class=''>";
    print "<div id='ca_date_con'>";
      print "<span id='ca_date_cont'>";
      print "Date Updated : ".$ann['date_posted'];
      print "</span>";
    print "</div>";
     //announcement content
    print "<div id='ca_content'>";
      print "{$ann['ann_stmt']}";
    print "</div>";
    print "<div id='ca-edit-pane'>";
      print "<form action='javascript:showEditAnnDg(\"popup_background\",\"popup_div\");' method='post'>";
      print "<input type='hidden' id='ann_id' name='ann_id' value='".$ann['ann_id']."'>";
      print "<input type='hidden' id='ann_stmt' name='ann_stmt' value='".$ann['ann_stmt']."'/>";
      print "<input type='submit' class='btn btn-default' value='edit'>";
      print "</form>";
    print "</div>";
    print "</br></br>";
    print "</div>";
  } 
}

function updateAnn(){// update an announcement in the display
  
}
        
?>
