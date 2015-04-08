<?php
 
class Resource{
  //database objects variables
  protected $db_connector;
  protected $query;
  protected $rs;

  //class variables
  protected $resource_id;
  protected $file_type;
  protected $location;
  

  public function __construct($connector){
    $this->db_connector = $connector;
  }
  
  public function getAllResources($id){
    $this->query = "SELECT *
                    FROM moco.lectmaterial
                    WHERE topic_id=$id";

    $this->rs = $this->db_connector->selectAll();
    if($this->rs) return $this->rs->fetchAll();
    else return null;
  }

  

}


?>