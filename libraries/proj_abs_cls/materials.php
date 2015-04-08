<?php

require_once '../../libraries/database/pdo/db_connect.php';
require_once '../../libraries/php/sanitizer.php';

abstract class Syllabus{

  //database object variables
  protected $db_connector;
  protected $query;//query string
  protected $rs;//resultset object
  
  protected $topicID;
  protected $title;
  protected $order;
  protected $subtopics;//array of Topic
  
  //abstract function
  public function __construct(){
    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
  }

  public function getAllChapters($id){
    //$id -> instructor course record
   
    $query = "SELECT * 
              FROM chapter
              WHERE ic_id=$id
              ORDER BY seq_no ASC
              ";

    $this->rs = $this->db_connector->selectAll($query);
    if($this->rs) return $this->rs->fetchAll();
    else return null;
  }
   
}
?>
