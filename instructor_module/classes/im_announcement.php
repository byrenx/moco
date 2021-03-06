<?php

include "../../libraries/proj_abs_cls/announcement.php";

class IM_Announcement extends Announcement{
  
  private $db_connector;
  private $query;

  public function __construct($connector){
    $this->db_connector = $connector;
  }

  public function getAllAnnouncement($icr_id){
    $this->query = "SELECT ann_id, 
                     ic_id, 
                     date_posted, 
                     ann_stmt
                   FROM announcement
                   WHERE ic_id=?";
    
    $rs = $this->db_connector->select($this->query, array($icr_id));

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }

  public function addNewCourseAnnouncement(){ 
    $this->addAnnouncement();
    echo $this->getNewAnnouncementPanel();
  }

  public function addAnnouncement(){
    $q_params = array(sanitize($_POST['icr_id']),
                      sanitize($_POST['ann_stmt'])
                    );//instructor course record id
    
    $this->query = "INSERT INTO announcement(ic_id, ann_stmt)
                 VALUES(?,?)";

    if($this->db_connector->insert($this->query, $q_params)){
      return true;
    }else{
      return false;
    }
    
  }

   public function updateAnnouncementPanel(){
    
     $str_ann_panel=null;
    if($this->updateAnnouncement()){
      $ann = $this->getUpdatedAnnouncement($_POST['ann_id']);

      $str_ann_panel.="<div id='ca_date_con'>";
      $str_ann_panel.="<span id='ca_date_cont'>";
      $str_ann_panel.="Date Updated : ".$ann['date_posted'];
      $str_ann_panel.="</span>";
      $str_ann_panel.="</div>";
      //announcement content
      $str_ann_panel.="<div id='ca_content'>";
      $str_ann_panel.="{$ann['ann_stmt']}";
      $str_ann_panel.="</div>";
      $str_ann_panel.="<div id='ca-edit-pane'>";
      $str_ann_panel.="<form action='javascript:showUpdateDelAnnDg(\"popup_background\",\"popup_div\");' method='post'>";
      $str_ann_panel.="<input type='hidden' id='ann_id' name='ann_id' value='".$ann['ann_id']."'>";
      $str_ann_panel.="<input type='hidden' id='ann_stmt' name='ann_stmt' value='".$ann['ann_stmt']."'/>";
      $str_ann_panel.="<button class='btn btn-default'  onclick='javascript:$(\"#action\").val(\"edit\")'>
                       <img src='../../images/pen_16.png'>
                       Edit</button>    ";
      $str_ann_panel.="<button class='btn btn-default' onclick='javascript:$(\"#action\").val(\"del\")'>
                       Delete</button>";
      $str_ann_panel.="</form>";
      $str_ann_panel.="</div>";
      $str_ann_panel.="</br></br>";
    }
    echo $str_ann_panel;
  }

  public function updateAnnouncement(){
    $q_params = array(sanitize($_POST['ann_stmt']),
                      $_POST['ann_id']
		      );

    $this->query = "UPDATE announcement SET
                    ann_stmt=?
                    WHERE ann_id=?";

    if($this->db_connector->update($this->query, $q_params)){
      return true;   
    }else{
      return false;
    }
  }

  public function deleteAnnouncement(){
    $this->query = "DELETE FROM announcement
                    WHERE ann_id=?";
    if($this->delete($this->query, array($_POST['ann_id']))){
      return true;
    }else{
      return false;
    }
  }
  
  public function getNewAnnouncement(){
    $this->query = "SELECT * FROM announcement
             WHERE ann_id=(SELECT MAX(ann_id)
             FROM announcement)";
     
    return $this->db_connector->selectAll($this->query)->fetch();
  }

  

  //private functions here
  private function getUpdatedAnnouncement($id){//getting the newly updated announcement
    $this->query = "SELECT * FROM 
                    announcement
                    WHERE ann_id=$id";
    $rs = null;
    if($rs=$this->db_connector->selectAll($this->query)){
      return $rs->fetch();
    }
    
    return null;
  }

  private function getNewAnnouncementPanel(){
    
    $ann = $this->getNewAnnouncement();
    $str_ann_panel = null;
    
    if($ann>0){
      $str_ann_panel.= "<div id='ca_ann_con' class='".$ann['ann_id']."'>";
      $str_ann_panel.="<div id='ca_date_con'>";
      $str_ann_panel.="<span id='ca_date_cont'>";
      $str_ann_panel.="Date Updated : ".$ann['date_posted'];
      $str_ann_panel.="</span>";
      $str_ann_panel.="</div>";
      //announcement content
      $str_ann_panel.="<div id='ca_content'>";
      $str_ann_panel.="{$ann['ann_stmt']}";
      $str_ann_panel.="</div>";
      $str_ann_panel.="<div id='ca-edit-pane'>";
      $str_ann_panel.="<form id='".$ann['ann_id']."' 
                       action='javascript:showUpdateDelAnnDg(\"popup_background\",\"popup_div\",\"".$ann['ann_id']."\");' method='post'>";
      $str_ann_panel.="<input type='hidden' id='action' name='action' value='edit'>";
      $str_ann_panel.="<input type='hidden' id='ann_id' name='ann_id' value='".$ann['ann_id']."'>";
      $str_ann_panel.="<input type='hidden' id='ann_stmt' name='ann_stmt' value='".$ann['ann_stmt']."'/>";
      $str_ann_panel.="<button class='btn btn-default'  onclick='javascript:$(\"#action\").val(\"edit\")'>
                       <img src='../../images/pen_16.png'>
                       Edit</button>    ";
      $str_ann_panel.="<button class='btn btn-default' onclick='javascript:$(\"#action\").val(\"del\")'>
                       Delete</button>";
      $str_ann_panel.="</form>";
      $str_ann_panel.="</div>";
      $str_ann_panel.="</br></br>";
      $str_ann_panel.="</div>";
    }

    return $str_ann_panel;
  }

  

}//end of class

?>