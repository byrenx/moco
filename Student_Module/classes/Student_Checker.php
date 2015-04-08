<?php

include "../../libraries/proj_abs_cls/student.php";

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
                                        icr.date_end,
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

  public function getOfferedCourses($pageNum, $maxRows){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c
                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id
                   ORDER BY date_start desc
                   LIMIT $pageNum, $maxRows";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }
  public function searchCoursebyCode($course_id){
    $this->query = "SELECT *
                    FROM instructorcourserecord icr,
                               employees i,
                               course c
                    WHERE i.IDNUMBER=icr.IDNUMBER
                    AND c.course_id=icr.course_id
                    AND icr.course_id like '%$course_id%'
                    ORDER BY date_start desc";
    $courses = $this->db_connector->selectAll($this->query);    
    return $courses->fetchAll();
  }
  public function searchCoursebyDept($dept){
    $this->query = "SELECT *
                    FROM instructorcourserecord icr,
                               employees i,
                               course c
                    WHERE i.IDNUMBER=icr.IDNUMBER
                    AND c.course_id=icr.course_id
                    AND d.dept_name like '%$dept%'
                    ORDER BY date_start desc";
    $courses = $this->db_connector->selectAll($this->query);
    
    return $courses->fetchAll();
  }
  public function searchCoursebyInst($LASTNAME){
    $this->query = "SELECT *
                    FROM instructorcourserecord icr,
                               employees i,
                               course c
                    WHERE i.IDNUMBER=icr.IDNUMBER
                    AND c.course_id=icr.course_id
                    AND i.LASTNAME like '%$LASTNAME%'
                    ORDER BY date_start desc";
    $courses = $this->db_connector->selectAll($this->query);
    
    return $courses->fetchAll();
  }
public function searchCoursebyTitle($keyWord){
    $this->query = "SELECT *
                    FROM instructorcourserecord icr,
                               employees i,
                               course c
                    WHERE i.IDNUMBER=icr.IDNUMBER
                    AND c.course_id=icr.course_id
                    AND c.course_desc like '%$keyWord%'
                    ORDER BY date_start desc";
    $courses = $this->db_connector->selectAll($this->query);
    
    return $courses->fetchAll();
  }

    public function getAllCourses(){

    $this->query = "SELECT *
		   FROM   instructorcourserecord icr,
				employees i,
				course c

                   WHERE i.IDNUMBER=icr.IDNUMBER
		   AND c.course_id=icr.course_id

                   ORDER BY date_start desc";

    $courses = $this->db_connector->selectAll($this->query);

    return $courses->fetchAll();
  }

  public function getMaxRows(){
      $this->query = 'SELECT count(*)
                      FROM instructorcourserecord';
      return $this->db_connector->count($this->query);
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
    $today = new DateTime();
    $incorrect= "ENTER CORRECT COURSEKEY!"; 
    $student_id = $_POST['std_id'];
    $course_id = $_POST['scr_id'];
    $course_key = $_POST['SCK'];
    $getCK = $this->getCourseKey($course_id);

    foreach($getCK as $key){
      $CK = $key['ck_key'];
    }
    if($this->isEnrolledExist($student_id,$course_id)){
	   exit();
    }else if(!$this->isCourseKeyExist($course_key,$course_id)){
          echo "invalid";
	  exit();
       }else
      echo "ok";
    $query_params = array(":stud_id"=>$student_id,":course_id"=>$course_id,":date_joined"=>$today->format('Y-m-d'));
     $this->query = "INSERT INTO studentcourserecord(IDNUMBER,ic_id,date_joined)
                      VALUES(:stud_id,:course_id,:date_joined)";
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
        $this->db_connector->delete($this->query, $query_params);
	return true;
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

  private function getCourseKey($course_id){
    $this->query = "SELECT *
                    FROM course_key
                    WHERE ic_id={$this->db_connector->quote($course_id)}";

    return $this->db_connector->selectAll($this->query)->fetchAll();
  }
}
 
?>
