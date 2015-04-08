<?php

include "../../libraries/proj_abs_cls/announcement.php";

class IM_Announcement extends Announcement{
  
  protected $db_connector;
  protected  $query;

  public function __construct($connector){
    $this->db_connector = $connector;
  }

  public function getAllAnnouncement($scr_id){
    $this->query = "SELECT 
                     scr.ic_id,
                     a.ic_id,
                     a.title,
                     a.ann_id,                 
                     a.date_posted, 
                     a.ann_stmt
                   FROM studentcourserecord scr
                   INNER JOIN announcement a
                      ON scr.ic_id=?
                         AND a.ic_id=scr.ic_id
                   ORDER BY date_posted desc";
    
    $rs = $this->db_connector->select($this->query, array($scr_id));

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }

public function getAllOpenAnnouncement($scr_id){
    $this->query = "SELECT 
                     icr.ic_id,
                     icr.course_type,
                     a.ic_id,
                     a.title,
                     a.ann_id,                 
                     a.date_posted, 
                     a.ann_stmt
                   FROM instructorcourserecord icr
                   INNER JOIN announcement a
                      ON icr.ic_id=$scr_id
                         AND icr.course_type=0
                         AND a.ic_id=icr.ic_id";
    
    $rs = $this->db_connector->select($this->query, array($scr_id));

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }


  

}//end of class

?>