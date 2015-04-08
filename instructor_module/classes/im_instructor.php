<?php

include "../../libraries/proj_abs_cls/instructor.php";

class IM_Instructor extends Instructor{
  private $query;
  private $rs;
  
  public function __construct($connector){
    $this->db_connector=$connector;
  }

  public function getTaughtCourses($id){
    //$arg_val = array($id);
    $this->query = "SELECT icr.instructor_id,
		           icr.course_id,
			   c.course_desc,
                           icr.ic_id,
                           icr.course_type
		   FROM instructorcourserecord icr,
		        course c
                   WHERE icr.instructor_id=$id
		   AND c.course_id=icr.course_id";
  
    $courses = $this->db_connector->selectAll($this->query);

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
