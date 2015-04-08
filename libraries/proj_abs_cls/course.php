<?php

abstract class Course{
  //database connector variable
  protected $db_connector;
  protected $query;//query string
  protected $rs; //query resultset object

  //class variables
  protected $courseID;
  protected $title;
  protected $description;
  protected $dept;//Department Object
  protected $syllabus; //Syllabus Object
  
  //abstract functions
  abstract public function __construct($connector);
  
  //abstract public function getMyCourses($my_id);
  

  //public functions
  public function getBasicCourseInfo($course_id){
    
    $course_id = $this->connector->quote($course_id);

    $this->query = "SELECT *
                    FROM course
                    WHERE course_id=$course_id";
    $this->rs = $this->db_connector->selectAll();

    if($this->rs) return $this->rs->fetchAll();
    else return null;   
  }

  public function getAllCourses(){
    
    $this->query = "SELECT * 
                    FROM course";

    $this->rs = $this->db_connector->selectAll($this->query);
    
    if($this->rs) return $this->rs->fetchAll();
    else return null;
  }

}

?>