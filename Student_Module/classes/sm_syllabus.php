<?php

include "../../libraries/proj_abs_cls/syllabus.php";

class SM_Syllabus extends Syllabus{

  protected $db_connector;
  protected $query;

  public function __construct($connector){
    $this->db_connector = $connector;
  }


  public function getAllSyllabus($scr_id){
    $this->query = "SELECT 
                       scr.ic_id,
                       ch.ic_id,
                       ch.title,
                       ch.seq_no,
                       ch.ch_id,
                           lec.ch_id,
                           lec.tittle,
                           lec.seq_no
                    FROM studentcourserecord scr
                         INNER JOIN chapter ch
                        ON scr.ic_id=$scr_id
                          AND ch.ic_id=scr.ic_id
                    INNER JOIN lecture lec
                        ON lec.ch_id=ch.ch_id
                     ORDER BY ch.seq_no,lec.seq_no";
                     
    $rs = $this->db_connector->selectAll($this->query, array($scr_id));

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }
public function getAllOpenSyllabus($scr_id){
    $this->query = "SELECT 
                       icr.ic_id,
                       icr.course_type,
                       ch.ic_id,
                       ch.title,
                       ch.seq_no,
                       ch.ch_id,
                           lec.ch_id,
                           lec.tittle,
                           lec.seq_no
                    FROM instructorcourserecord icr
                         INNER JOIN chapter ch
                        ON icr.ic_id=$scr_id
                          AND ch.ic_id=icr.ic_id
                          AND icr.course_type=0
                    INNER JOIN lecture lec
                        ON lec.ch_id=ch.ch_id
                     ORDER BY ch.seq_no,lec.seq_no";
                     
    $rs = $this->db_connector->selectAll($this->query,$scr_id);

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }

}
?>