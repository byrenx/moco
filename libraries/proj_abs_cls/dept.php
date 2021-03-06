<?php

    abstract class Department{
      protected $dep_id;
      protected $dept_name;
      protected $dept_arr;
      protected $db_connector;
      protected $query;

      abstract public function __construct($connector);
      
      /*protected function loadAllDept(){
        $this->query="SELECT * FROM moco.dept";

        $rows=$this->db_connector->selectAll($this->query)->fetchAll();

        foreach($rows AS $row){
          $this->dept_arr[]=array("id"=>$row[0],
                           "name"=>$row[1]);
        }  
      } */

      public function getDepartment($d_id){
        $dept = null;
        for($i=0; $i<count($dept_arr);$i++){
          if($dept_arr[$i]["id"]==$d_id){
            $dept = $dept_arr[$i]["name"]; 
            break;
          }
        }
        return $dept;
      }

      public function getAllDept(){
        return $this->dept_arr;
      }
   }

?>
