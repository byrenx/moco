<?php
require_once "../../libraries/database/pdo/db_connect.php";

class IMStudentRoster{
  protected $db_connector;

  public function __construct(){
    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
  }


  public function getStudentsbyID($params){
    
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
              where studentcourserecord.ic_id = ?
                   and studentcourserecord.idnumber like ?
             ";
      return $this->db_connector->select($query, $params)->fetchAll();
  }

  public function getAllStudent($params){
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
              where studentcourserecord.ic_id = ? 
              order by studentcourserecord.date_joined desc
             ";
      return $this->db_connector->select($query, $params)->fetchAll();

  }

  public function getStudentsbyFirstname($params){
    
    $query = "select *
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
                   and students.firstname like ?
              where studentcourserecord.ic_id = ?
             ";

    return $this->db_connector->select($query, $params)->fetchAll();
  }

  public function getStudentsbyLastname($params){
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
                   and students.lastname like ?
              where studentcourserecord.ic_id = ? 
             ";
     return $this->db_connector->select($query, $params)->fetchAll();
  }

  public function getStdentsbyYear($params){
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
                   and year(date_joined)= ?
              where studentcourserecord.ic_id = ? 
             ";
     return $this->db_connector->select($query, $params)->fetchAll();
  }

  public function getStudentsbyMonthYear($params){
    $query = "select studentcourserecord.*, students.*
              from studentcourserecord
              inner join students on
                   students.idnumber = studentcourserecord.idnumber
                   and year(studentcourserecord.date_joined)= ? and month(studentcourserecord.date_joined) = ?
              where studentcourserecord.ic_id = ? 
             ";
     return $this->db_connector->select($query, $params)->fetchAll();
  }

  public function unenroll(){
    /*
     * params: $scr_id -> student course record
     */
    $scr_id = $_POST['scr_id'];
    $query = "delete from studentcourserecord where scr_id= $scr_id";
    $delete = $this->db_connector->delete($query);
    if ($delete){
      header("location: ../../instructor_module/pages/student_roster.php?status=sd");
    }else{
      header("location: ../../instructor_module/pages/student_roster.php?status=errd");
    }
  }

}

?>