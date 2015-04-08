<?php

require_once "../../libraries/proj_abs_cls/announcement.php";

class IM_Announcement extends Announcement{
  
  public function __construct(){
    parent::__construct();
  }
  
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

    $this->db_connector->insert($this->query, $q_params);
  }

  public function agn_ann(){//add then get new announcement
    //use transaction
    try{
      $this->db_connector->trans_beg();
      $this->addAnnouncement();
      $ann = $this->getNewAnnouncement();
      $this->db_connector->commit();
      return $ann;
    }catch(Exception $e){
      $this->db_connector->rollback();
      return null;
    }
  }

  public function updateAnnouncement(){
    $q_params = array(sanitize($_POST['ann_title']),
                      ($_POST['ann_stmt']),
		      date(DATE_ATOM),
                      $_POST['ann_id']
		      );

    $this->query = "UPDATE announcement SET
                    title = ?,
                    ann_stmt = ?,
                    date_edited = ?
                    WHERE ann_id = ?";

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
                    WHERE ann_id = (select max(ann_id) from announcement)
                    ";
     
    return $this->db_connector->selectAll($this->query)->fetch();
  }

  public function getAnnouncement($ann_id){
    $query = "select * from announcement where ann_id=?";
    return $this->db_connector->select($query, array($ann_id))->fetch();
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

  public function isExist(){
    $this->query = "select * from announcement where title=:title and ann_stmt=:ann_stmt
                    and ic_id=:ic_id";
    return $this->db_connector->doesExistSelect($this->query, 
						array(":title"=>sanitize($_POST['ann_title']),
						      ":ann_stmt"=>sanitize($_POST['ann_stmt']),
						      ":ic_id"=>$_POST['icr_id']));
  }

}//end of class

?>