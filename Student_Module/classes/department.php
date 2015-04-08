<?php
   include "../../libraries/proj_abs_cls/dept.php";
   

   class IMDepartment extends Department{
     
     public function __construct($connector){
       $this->db_connector=$connector;
       $this->loadAllDept();
     }  
   }

?>