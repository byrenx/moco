<?php
require_once "../class_models/student_roster_model.php"

class StudentRosterInterface{
  protected $stud_roster;

  public function __construct(){
    $this->stud_roster = new IMStudentRoster();
  }

  public function getStudents(){
    $filter = $_POST['filter'];
    $student_list = 1;
  }

}
?>