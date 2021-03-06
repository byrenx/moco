<?php
require_once "../../libraries/database/pdo/db_connect.php";

class IMStudentProfile{
  protected $db_connector;

  public function __construct(){
    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
  }

  public function getStudentInfo($id_number, $ic_id){
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
              where studentcourserecord.ic_id = ?
                   and studentcourserecord.idnumber = ?";

    return $this->db_connector->select($query, array($ic_id, $id_number))->fetch();
  }

  public function getQuizResults($ic_id, $student_id){
    $query = "select * from studentcourserecord
                    inner join studenttestrec on
                    studenttestrec.scr_id = studentcourserecord.scr_id
                    inner join test on
                    test.test_id = studenttestrec.test_id
                       and test.test_type=0
              where studentcourserecord.ic_id = ? and studentcourserecord.IDNUMBER= ?
             ";
    return $this->db_connector->select($query, array($ic_id, $student_id))->fetchAll();
  }

  public function getAssignmentResults($ic_id, $student_id){
    $query = "select * from studentcourserecord
                    inner join ass_submission on
                    ass_submission.scr_id=studentcourserecord.scr_id
                    inner join assignment on
                    assignment.assign_id=ass_submission.assign_id
              where studentcourserecord.ic_id = ? and studentcourserecord.IDNUMBER= ?";
    return $this->db_connector->select($query, array($ic_id, $student_id))->fetchAll();
  }

  public function getExamResults($ic_id, $student_id){
    $query = "select * from studentcourserecord
                    inner join studenttestrec on
                    studenttestrec.scr_id = studentcourserecord.scr_id
                    inner join test on
                    test.test_id = studenttestrec.test_id
                       and test.test_type=1
              where studentcourserecord.ic_id = ? and studentcourserecord.IDNUMBER= ?
             ";
    return $this->db_connector->select($query, array($ic_id, $student_id))->fetchAll();
  }

}


?>