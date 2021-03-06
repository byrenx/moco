<?php
require_once "../../libraries/database/pdo/db_connect.php";
require_once "../../libraries/php/sanitizer.php";

abstract class Assignment{
  protected $db_connector;
  protected $query;
  protected $id;
  protected $inst;
  protected $inst_mat;
  protected $dd;
  protected $da;
  
  public function __construct(){
    $this->db_connector = new DBConnector();
  }

  public function connect_to_db(){
    $this->db_connector->connect();
  }
  
  
  public function getAssignment($id){
    $this->query = "SELECT * FROM assignment WHERE assign_id = $id";
    return $this->db_connector->selectAll($this->query)->fetch();
  }

  public function getAllCourseAss($ic_id){
    /*
      $ic_id => nstructor course record id
      postcondition: return a list of assignment dictionary
                     of a certain course taught by instructor
     */

    $this->query = "SELECT assignment.*,
                      (select count(*) from ass_submission where assign_id=assignment.assign_id) as submissions
                      FROM assignment
                      WHERE ic_id = $ic_id 
                      ORDER BY  assign_id DESC";
    return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  
}

?>