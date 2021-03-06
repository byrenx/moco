<?php
   include "../../libraries/proj_abs_cls/dept.php";
   

   class IMDepartment extends Department{
     
     public function __construct($connector){
       $this->db_connector=$connector;
       //$this->loadAllDept();
     }  
     
     public function addNewDept($dept_name){
       $dept_name = array(sanitize($dept_name));
       $this->query = "INSERT INTO dept(dept_name)
                       VALUES(?)";
       return $this->db_connector->insert($this->query,$dept_name);

     }

     public function getNewDept(){
       $this->query = "SELECT * FROM dept
                       WHERE dept_id = (SELECT MAX(dept_id)
                                       FROM dept)";
       return $this->db_connector->selectAll($this->query)->fetch();
     }
     
     
   }

?>
