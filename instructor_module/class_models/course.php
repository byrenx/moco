<?php

require_once "../../libraries/proj_abs_cls/course.php";
require_once "department.php";
require_once "../../libraries/php/time_lib.php";

class IMCourse extends Course{	 
    /*
     * public functions
     */
    protected $dept;

    public function __construct($connector){
      $this->db_connector = $connector;
      $this->dept = new IMDepartment($connector);
    }
	 
    public function teachACourse(){
      $course_opt = $_POST["course_opt"];
      $course_params = array(":cc"=>sanitize($_POST['cc']),
                             ":cdesc"=>sanitize($_POST['cdesc']),
			     );

      $instructor_params = array(":c_id"=>sanitize($_POST['cc']),
                                 ":inst_id"=>sanitize($_POST['inst_id']),
                                 ":overview"=>sanitize($_POST['overview']),
                                 ":ctype"=>sanitize($_POST['ctype']),
                                 ":date_start"=>"0000-00-00",
                                 ":date_end"=>"0000-00-00"
                                );
      if ($course_opt==1){//ad new course
	$instructor_params[':c_id'] = sanitize($_POST['ccode']);
      }

      if($this->hasCourse($instructor_params)){
	$url_get = 'status='.urlencode('duplicate entry').'&'.
	  'ccode='.urlencode($instructor_params[':c_id']).'&'.
	  'title='.urlencode($course_params[':cdesc']);
	header("Location: ../../instructor_module/pages/add_course.php?".$url_get);
      }else{
	try{
	  $this->db_connector->trans_beg();
	  /*
	  if($dept_opt==1){//new department must be created
	    $this->dept->addNewDept($_POST["dept_name"]);
	    $new_dept = $this->dept->getNewDept();
	    $course_params[":dept"] = $new_dept[0];
	    }*/
	  
	  if($course_opt==1){//new course must be created first
	    $course_params[":cc"] = $_POST["ccode"];
	    $instructor_params[":c_id"] = $_POST["ccode"];
	    $this->addCourse($course_params);
	  }else{
	    $this->updateCourse($course_params);
	  }
	  
	  //check if it is OCW or OC
	  if($_POST["ctype"]==1){
	    //add start and end dates
	     $time_lib = new TimeLib();
	     $instructor_params[":date_start"] = $time_lib->dateSQL($_POST["start_date"]);
	     $instructor_params[":date_end"] = $time_lib->dateSQL($_POST["end_date"]);	
	  }
	   //add new course to an instructor
	  $this->addInstructorCourse($instructor_params);
	  
	  if($instructor_params[':ctype']==1){
	    $this->addCoursekey();
	  }
	  $this->db_connector->commit();
	  //close database connection
	  //$this->db_connector->closeConn();
	  header("Location: ../../instructor_module/pages/course_dashboard.php");
	}catch(Exception $e){
	  $this->db_connector->rollback();
	  $status = urlencode('connect fail');
	  header("Location: ../../instructor_module/pages/add_course.php?status=$status");
	}
      }
    }

    public function addCourse($query_params){
      $this->query = "INSERT INTO course(course_id,course_desc)
                      VALUES(:cc, :cdesc)";
      try{
        $this->db_connector->insert($this->query, $query_params);
      }catch(Exception $ex){
        //redirect to system error page 
      }
    }

    public function updateCourse($course_params){
       
       $this->query = "UPDATE course SET 
                       course_desc=:cdesc,
                       dept_id=:dept
                       WHERE course_id=:cc";
       $this->db_connector->update($this->query, $course_params);
    }

    public function getCourseInfo($ic_id){
      /*
       * $ic_id -> instructor course record id
       * 
       */
      
      $this->query = "SELECT icr.ic_id,
                             icr.course_overview,
                             icr.course_type,
                             c.course_id,
                             c.course_desc,
                             date_format(icr.date_start, '%m/%d/%Y') as date_start,
                             ck.ck_key,
                             date_format(icr.date_end, '%m/%d/%Y') as date_end
                      FROM instructorcourserecord icr
                      INNER JOIN course c
                        ON icr.ic_id= :ic_id 
                           AND c.course_id=icr.course_id
                      LEFT JOIN course_key ck
                        ON ck.ic_id = :ic_id";

      return $this->db_connector->select($this->query,array(":ic_id"=>$ic_id))->fetch();
    }

    public function switchCOurseType($icrd, $c_type){
      /* $icrd ->  is a instructor course record id
	 $c_type -> is the new course type after this update
       */
      $this->updateCourseType($icrd, $c_type);
      if($c_type==1){
	//generate course key
	$this->addNewCk($icrd);
	//get course key
	echo $this->getCk($icrd);
      }
      
    }

    public function getCk($icrd){
      /* $icrd -> instructor course record id
	 postcondition:
	 returns the course key associated to icrd
       */
      $query = "SELECT ck_key FROM course_key
                WHERE ic_id=$icrd";
      return $this->db_connectors->selectAll($query)->fetchColumn();
    }

    public function updateCourseType($icrd, $c_type){
      $query = "UPDATE instructorcourserecord
                SET course_type=?
                WHERE ic_id=?";
      return $this->db_connector->update($query, array($c_type, $icrd));
    }

    /*
     * private functions
     *
     */
	 
    private function addInstructorCourse($query_params){				 
      $this->query = "INSERT INTO instructorcourserecord
                     (course_id, 
                      IDNUMBER,
                      course_overview,
                      course_type,
                      date_start,
                      date_end)
		     VALUES(:c_id,
                            :inst_id,
                            :overview,
                            :ctype,
                            :date_start,
                            :date_end
                     )";
      //insert Intructor course Record
      $this->db_connector->insert($this->query, $query_params);
      
    }

    private function genCoursekey($length=6){
      $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      $char = str_shuffle($char);
      for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
        $rand .= $char{mt_rand(0, $l)};
      }
      return $rand;
    }
   
    public function addCoursekey(){
      $this->query = "INSERT INTO course_key(ck_key, ic_id)
                      VALUES(:ck_key,
                             (SELECT MAX(ic_id) FROM instructorcourserecord)
                            )";
      $this->db_connector->insert($this->query, array(":ck_key"=>$this->genCoursekey()));
      
    }

    public function ack2exist_course($ic_id){
      $this->query = "INSERT INTO course_key(ck_key, ic_id)
                      VALUES(:ck_key, :ic_id)";
      $this->db_connector->insert($this->query,
				  array(":ck_key"=>$this->genCoursekey(), 
					":ic_id"=>$ic_id));

    }

    public function addNewCk($ic_id){
      $this->query = "INSERT INTO course_key(ck_key, ic_id)
                      VALUES(:ck_key,:icrd
                            )";
      $this->db_connector->insert($this->query, array(":ck_key"=>$this->genCoursekey(), ":icrd"=>$ic_id));
      
    }

    public function hasCourse($param){
      $query = "SELECT * FROM instructorcourserecord 
                WHERE course_id=:c_id
                AND IDNUMBER = :inst_id";
      return $this->db_connector->doesExistSelect($query, 
	     array(':c_id'=>$param[':c_id'],
		   ':inst_id'=>$param[':inst_id']));
    }

    
    private function isCourseExist($c_id){

      $this->query = "SELECT COUNT(*) FROM 
                     course 
                     WHERE course_id={$this->db_connector->quote($c_id)}";
     
      return $this->db_connector->doesExist($this->query);
    }
    
}

?>
 
