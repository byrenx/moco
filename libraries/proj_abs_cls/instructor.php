<?php

abstract class Instructor{

  protected $db_connector;

  abstract function __construct();
  
  abstract public function getAllCourse($id);
  
  /*
     this function returns an array of instructor information
  */
  public function getInsInfo($id){
    return null;
  }

}

?>
