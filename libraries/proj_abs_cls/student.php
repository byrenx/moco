<?php

abstract class Student{

  protected $db_connector;

  abstract function __construct($connector);
  
  abstract public function getEnrolledCourses($id);
  
  /*
     this function returns an array of instructor information
  */
  public function getStudInfo($id){
    return null;
  }

}

?>
