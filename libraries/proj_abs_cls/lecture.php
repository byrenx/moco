<?php

 abstract class Lecture{
   protected $db_connector;
   protected $query;
   protected $q_params;
   protected $rs;
  
   abstract function __conectruct($connector){
     $this->db_connector = $connector;
   }

   public function getAlllectures($chapter_id){
     $this->query = "SELECT * FROM 
                     lecture WHERE 
                     ch_id=$chapter_id";
     return $this->db_connector->selectAll($this->query)->fetchAll();
   }
 }


?>