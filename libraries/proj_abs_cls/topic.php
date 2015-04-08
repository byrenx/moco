<?php

class Topic{

  //database object variables
  protected $db_connector;
  protected $query;//query string
  protected $rs;//resultset object
  
  protected $topicID;
  protected $title;
  protected $order;
  protected $subtopics;//array of Topic
  
  //abstract function
  public function __construct($connector){
    $this->db_connector = $connector;
    $this->subtopics = null;
  }

  public function getAllMainTopic($id){
    $query = "SELECT * 
              FROM moco.maintopic";

    $this->rs = $this->db_connector->selectAll($query);
    if($this->rs) return $this->rs->fetchAll();
    else return null;
  }
  
  public function getSubTopics($id){
    $this->query = "SELECT *
                    FROM moco.subtopic
                    WHERE maintopic_id=$id";
    $this->rs = $this->db_connector->selectAll();
    if($this->rs) return $this->rs->fetchAll();
    else return null;
  } 
  
}
?>