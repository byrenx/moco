<?php

include "../../libraries/proj_abs_cls/course.php";

class IMCourse extends Course{
    
     
    /*
     * public functions
     */

    public function __construct($connector){
      $this->db_connector = $connector;
      
    }
	 
   
    public function getCourseInfo($ic_id){
      /*
       * $ic_id -> student  course record id
       * 
       */
      
      $this->query = "SELECT scr.ic_id,
                             icr.ic_id,
                             icr.course_overview,
                             icr.course_type,
                             icr.IDNUMBER,
                             e.LASTNAME, e.FIRSTNAME,
                             e.IDNUMBER,                             
                             c.course_id,
                             c.course_desc
                      FROM studentcourserecord scr
                      INNER JOIN instructorcourserecord icr
                        ON scr.ic_id=?
                            AND icr.ic_id=scr.ic_id
                      INNER JOIN course c
                        ON c.course_id=icr.course_id
                      INNER JOIN employees e
                        ON e.IDNUMBER=icr.IDNUMBER";

      return $this->db_connector->select($this->query,array($ic_id))->fetch();
    }
 public function getOpenCourseInfo($ic_id){
      /*
       * $ic_id -> student  course record id
       * 
       */
      
      $this->query = "SELECT icr.ic_id,
                             icr.course_overview,
                             icr.course_type,
                             icr.IDNUMBER, 
                                e.IDNUMBER,
                                e.FIRSTNAME,
                                e.LASTNAME,
                             c.course_id,
                             c.course_desc
                      FROM instructorcourserecord icr
                       INNER JOIN course c
                        ON icr.ic_id=?
                          AND c.course_id=icr.course_id
                      INNER JOIN employees e
                        ON e.IDNUMBER=icr.IDNUMBER";

      return $this->db_connector->select($this->query,array($ic_id))->fetch();
    }

public function getOnlineCourseInfo($ic_id){
      /*
       * $ic_id -> student  course record id
       * 
       */
      
      $this->query = "SELECT icr.ic_id,
                             icr.course_overview,
                             icr.course_type,
                             icr.IDNUMBER,
                             icr.date_start,
                             icr.date_end,
                             icr.status,
                                c.course_id,
                                c.course_desc,
                                e.IDNUMBER,
                                e.FIRSTNAME,
                                e.LASTNAME,
                                e.MIDDLENAME
                      FROM instructorcourserecord icr
                       INNER JOIN course c
                        ON icr.ic_id=?
                          AND icr.course_type=1
                          AND c.course_id=icr.course_id
                      INNER JOIN employees e
                        ON e.IDNUMBER=icr.IDNUMBER";

      return $this->db_connector->select($this->query,array($ic_id))->fetch();
    }


    /*
     * private functions
     *
     */
    
    private function isCourseExist($c_id){

      $this->query = "SELECT COUNT(*) FROM 
                     course 
                     WHERE course_id={$this->db_connector->quote($c_id)}";
     
      return $this->db_connector->doesExist($this->query);
    }
 
}


?>
 
