<?php

include "course.php";

class OnlineCourse extends Course{

  public function __construct($connector){
    $this->db_connector = $connector;
  }
}

?>