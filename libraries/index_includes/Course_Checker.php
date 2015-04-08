<?php

include "libraries/proj_abs_cls/student.php";

class Student_Checker extends Student{
  private $query;
  private $rs;
  
  public function __construct($connector){
    $this->db_connector=$connector;
  }

  public function getEnrolledCourses($id){
    //$arg_val = array($id);
    $this->query = "SELECT scr.IDNUMBER,
		           scr.ic_id,
				   scr.scr_id,
					icr.course_id,
						c.course_id,
						c.course_desc,
					icr.IDNUMBER,
					icr.course_overview, 
						i.LASTNAME,
						i.FIRSTNAME,
						i.IDNUMBER
		   FROM studentcourserecord scr,
		        instructorcourserecord icr,
				employees i,
				course c
                   WHERE scr.IDNUMBER=$id
		   AND i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id
		   AND icr.ic_id=scr.ic_id";
  
    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }

  public function getOfferedCourses(){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c

                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id

                   ORDER BY icr.date_start desc";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }
public function getLatestCourses(){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c
                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id
                   ORDER BY icr.date_start desc
                   LIMIT 7";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }

  public function getOfferedOnline(){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c

                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id

                   AND icr.course_type=1
                   ORDER BY date_start desc";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }

  public function getOfferedOpen(){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c
                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id

                   AND icr.course_type=0";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }

  public function enrollACourse(){
    $incorrect= "ENTER CORRECT COURSEKEY!"; 
    $student_id = $_POST['std_id'];
    $course_id = $_POST['scr_id'];
    $course_key = $_POST['SCK'];
    if($this->isEnrolledExist($student_id,$course_id)){

	   exit();
    }else if(!$this->isCoursekeyExist($course_key,$course_id)){
          echo "invalid";
	  exit();
       }else
      echo "ok";
     $query_params = array(":stud_id"=>$student_id,":course_id"=>$course_id);
     $this->query = "INSERT INTO studentcourserecord(IDNUMBER,ic_id)
                      VALUES(:stud_id,:course_id)";
      try{
        $this->db_connector->insert($this->query, $query_params);
        
      }catch(Exception $ex){
        //redirect to system error page 
      }
  }

  public function UnenrollACourse(){
     $query_params = array(":stud_id"=>$_POST['std_id'],":ic_id"=>$_POST['scr_id']);
     $this->query = "DELETE FROM studentcourserecord
                      WHERE IDNUMBER=:stud_id
                      AND ic_id=:ic_id";
      try{
        print_r($query_params);
        $this->db_connector->delete($this->query, $query_params);
        
      }catch(Exception $ex){
        //redirect to system error page 
      }
  }

 public function isEnrolledExist($stud_id,$course_id){
    $this->query = "SELECT COUNT(*)
                    FROM studentcourserecord
                    WHERE IDNUMBER={$this->db_connector->quote($stud_id)}
                    AND ic_id={$this->db_connector->quote($course_id)}";

    return $this->db_connector->doesExist($this->query);
  }
  private function isCourseKeyExist($course_key,$course_id){
    $this->query = "SELECT COUNT(*)
                    FROM course_key
                    WHERE ic_id={$this->db_connector->quote($course_id)}
                    AND ck_key={$this->db_connector->quote($course_key)}";

    return $this->db_connector->doesExist($this->query);
  }


}

?>
