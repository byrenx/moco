<?php

include "../../libraries/proj_abs_cls/course.php";

class IMCourse extends Course{
    
     
    /*
     * public functions
     */

    public function __construct($connector){
      $this->db_connector = $connector;
      
    }
	 
    public function teachACourse(){
       try{	
	
	  
	  $course_params = array(":cc"=>sanitize($_POST['cc']),
				 ":cdesc"=>sanitize($_POST['cdesc']),
			         ":dept"=>sanitize($_POST['dept'])
		           );

          $instructor_params = array(":c_id"=>sanitize($_POST['cc']),
                                     ":inst_id"=>sanitize($_POST['inst_id']),
                                     ":overview"=>sanitize($_POST['overview']),
                                     ":ctype"=>sanitize($_POST['ctype'])
                               );
        
          if($this->isCourseExist($course_params[':cc'])){
            $this->addInstructorCourse($instructor_params);
          }else{ //add a new course
            $this->addCourse($course_params);
            $this->addInstructorCourse($instructor_params);
	  }

          if($instructor_params[':ctype']==1){
            $this->addCoursekey();
          }

       }catch(Exception $e){             
         //redirect to to system error notification page
         
       }
    }

    public function addCourse($query_params){
      $this->query = "INSERT INTO course(course_id,course_desc, dept_id)
                      VALUES(:cc,:cdesc,:dept)";
      try{
        print_r($query_params);
        $this->db_connector->insert($this->query, $query_params);
      }catch(Exception $ex){
        //redirect to system error page 
      }
    }

    public function updateCourse(){
       $course_params = array(":cc"=>sanitize($_POST['cc']),
			      ":cdesc"=>sanitize($_POST['cdesc']),
			      ":dept"=>sanitize($_POST['dept'])
		            );
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
                             d.dept_id,
                             d.dept_name
                      FROM instructorcourserecord icr
                      INNER JOIN course c
                        ON icr.ic_id=? 
                           AND c.course_id=icr.course_id
                      INNER JOIN dept d
                        ON d.dept_id=c.dept_id";

      return $this->db_connector->select($this->query,array($ic_id))->fetch();
    }


    /*
     * private functions
     *
     */
	 
    private function addInstructorCourse($query_params){				 
      $this->query = "INSERT INTO instructorcourserecord
                     (course_id, instructor_id, course_overview,course_type)
		     VALUES(:c_id,:inst_id,:overview,:ctype)";
      //insert Intructor course Record
      $this->db_connector->insert($this->query, $query_params);
    }

    private function genCoursekey(){
      return rand(48,57).
             chr(rand(65,90)).
             chr(rand(65,90)).
             rand(48,57).
	     chr(rand(65,90)).chr(rand(65,90));
    }
   
    private function addCoursekey(){
      $this->query = "INSERT INTO course_key(ck_key, ic_id)
                      VALUES(:ck_key,
                             (SELECT MAX(ic_id) FROM instructorcourserecord)
                            )";
      $this->db_connector->insert($this->query, array(":ck_key"=>$this->genCoursekey()));
    }

    
    private function isCourseExist($c_id){

      $this->query = "SELECT COUNT(*) FROM 
                     course 
                     WHERE course_id={$this->db_connector->quote($c_id)}";
     
      return $this->db_connector->doesExist($this->query);
    }
 
}
?>
 