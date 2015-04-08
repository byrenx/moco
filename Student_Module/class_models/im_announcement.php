<?php

require_once "../../libraries/proj_abs_cls/announcement.php";

class IM_Announcement extends Announcement{
  
  public function addNewCourseAnnouncement(){ 
    
    echo $this->getNewAnnouncementPanel();
  }

  public function addAnnouncement(){
    $q_params = array(sanitize($_POST['icr_id']),
                      sanitize($_POST['ann_title']),
                      ($_POST['ann_stmt'])
                    );//instructor course record id
    
    $this->query = "INSERT INTO announcement(ic_id, title, ann_stmt)
                 VALUES(?,?,?)";

    if($this->db_connector->insert($this->query, $q_params)){
      return true;
    }else{
      return false;
    }
  }

  public function updateAnnouncement(){
    $q_params = array(sanitize($_POST['ann_title']),
                      ($_POST['ann_stmt']),
                      $_POST['ann_id']
		      );

    $this->query = "UPDATE announcement SET
                    title=?,
                    ann_stmt=?
                    WHERE ann_id=?";

    if($this->db_connector->update($this->query, $q_params)){
      return true;   
    }else{
      return false;
    }
  }

  public function delAnnouncement(){
    $this->query = "DELETE FROM announcement
                    WHERE ann_id=?";
    if($this->db_connector->delete($this->query, array($_POST['ann_id']))){
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
  public function getUpdatedAnnouncement($id){
    //getting the newly updated announcement
    $this->query = "SELECT * FROM 
                    announcement
                    WHERE ann_id=$id";
    $rs = null;
    if($rs=$this->db_connector->selectAll($this->query)){
      return $rs->fetch();
    }
    return null;
  }

}//end of class

?>