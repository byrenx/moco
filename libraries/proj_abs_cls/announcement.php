<?php

require_once '../../libraries/database/pdo/db_connect.php';
require_once '../../libraries/php/sanitizer.php';

abstract class Announcement{
  protected $db_connector;
  protected $query;

  public function __construct(){
    $this->db_connector = new DBConnector();
    $this->db_connector->connect();
  }

  public function getAllAnnouncement($icr_id){
    $this->query = "SELECT *
                   FROM announcement
                   WHERE ic_id=?
                   ORDER BY date_posted DESC";
				   
    $rs = $this->db_connector->select($this->query, array($icr_id));

    if($rs){
      return $rs->fetchAll();
    }else{
      return null;
    }
  }

} 

?>