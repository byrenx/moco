<?php

include "../../libraries/proj_abs_cls/instructor.php";
require_once '../../libraries/database/pdo/db_connect.php';

class IM_Instructor extends Instructor{
  private $query;
  private $rs;
  
  public function __construct(){
    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
  }

  public function getAllCourse($id){
    //$arg_val = array($id);
    $this->query = "SELECT icr.idnumber,
		           icr.course_id,
			   c.course_desc,
                           icr.ic_id,
                           icr.course_type
		   FROM instructorcourserecord icr,
		        course c
                   WHERE icr.IDNUMBER=$id
		   AND c.course_id=icr.course_id";
  
    $courses = $this->db_connector->selectAll($this->query);
    return $courses->fetchAll();
  }
  
  public function getOC($icr_id){//Online COurse
    $this->query = "SELECT icr.idnumber,
		           icr.course_id,
			   c.course_desc,
                           icr.ic_id,
                           icr.course_type
		   FROM instructorcourserecord icr,
		        course c
                   WHERE icr.IDNUMBER=?
		   AND c.course_id=icr.course_id
                   AND icr.course_type=1";
    $courses = $this->db_connector->select($this->query, array(sanitize($icr_id)));

    return $courses->fetchAll();
  }

  public function getOCW($icr_id){//Online Courses
    $this->query = "SELECT icr.idnumber,
		           icr.course_id,
			   c.course_desc,
                           icr.ic_id,
                           icr.course_type
		   FROM instructorcourserecord icr,
		        course c
                   WHERE icr.IDNUMBER=?
		   AND c.course_id=icr.course_id
                   AND icr.course_type=0";
    $courses = $this->db_connector->select($this->query, array(sanitize($icr_id)));

    return $courses->fetchAll();
  }

  public function updateTeachCourse(){
    try{
     $instructor_params = array( ":ic_id"=>sanitize($_POST['ic_id']),
                                 ":overview"=>sanitize($_POST['overview']),
                                 ":ctype"=>sanitize($_POST['ctype'])
                               );
    
     $this->query="UPDATE instructorcourserecord SET
                   course_overview=:overview,
                   course_type=:ctype
                   WHERE ic_id=:ic_id";
     $this->db_connector->update($this->query, $instructor_params);
    }catch(Exception $e){
      echo "There is an error in updating instructor course record";
    }
  }
}

?>
