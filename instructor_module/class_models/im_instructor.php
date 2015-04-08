<?php

require_once "../../libraries/proj_abs_cls/instructor.php";
require_once "course.php";
require_once '../../libraries/database/pdo/db_connect.php';
require_once "../../libraries/php/time_lib.php";
require_once "department.php";


class IM_Instructor extends Instructor{
  protected $query;
  protected $rs;
  protected $course;
  protected $dept;
  
  public function __construct(){

    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
    //course class
    $this->course= new IMCOurse($this->db_connector);
    //IMDepartment class
    $this->dept = new IMDepartment($this->db_connector);
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
                   course_type=:ctype";

     /*     if($instructor_params[':ctype']==0){
       $this->query.='DELETE FROM course_key WHERE ';
       }*/
     
     if($_POST['ctype']==1){
       $time_lib = new TimeLib();
       $instructor_params[":date_start"] = $time_lib->dateSQL($_POST['start_date']);
       $instructor_params[":date_end"] = $time_lib->dateSQL($_POST['end_date']);
       $this->query.=",  date_start=:date_start,
                         date_end=:date_end";
     }
     
     $this->query.=" WHERE ic_id=:ic_id";

     $course_params = array(":cdesc"=>sanitize($_POST['cdesc']),
			    ":dept"=>sanitize($_POST['dept']),
			    ":cc"=>sanitize($_POST['cc'])
			    );

     $this->db_connector->trans_beg();
     if($_POST['dept_opt']==1){//new department must be created
	$this->dept->addNewDept($_POST["dept_name"]);
	$new_dept = $this->dept->getNewDept();
        $course_params[":dept"] = $new_dept[0];
     }
     
     
      //update course
      $this->course->updateCourse($course_params);
      //update instructor course record
      //if change to online course then 
      //add curse key
      if($instructor_params[':ctype']==1){
	if(!$this->db_connector->doesExistSelect('select * from course_key where ic_id=?', array($instructor_params[':ic_id']))){
	  $this->course->ack2exist_course($instructor_params[':ic_id']);
	}
      }else{
        $this->db_connector->delete("DELETE FROM course_key WHERE ic_id = ?", array($instructor_params[':ic_id']));
      }

      $this->db_connector->update($this->query, $instructor_params);

      $this->db_connector->commit(); 
      
      
      
    }catch(Exception $e){
      $this->db_connector->rollback();
      echo "There is an error in updating instructor course record";
      
    }
  }

  
}

?>
