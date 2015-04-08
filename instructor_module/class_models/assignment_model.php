<?php

require_once "../../libraries/proj_abs_cls/assignment.php";

class AssignmentModel extends Assignment{
  
  public function addAssignment($ass_params){

    if($_FILES["f_attach"]["name"]==''){
      $ass_params[":im"] = $_FILES["f_attach"]["name"];
      $this->query = "INSERT INTO assignment(ic_id, title, instruction, inst_material, due_date, date_available)
                      VALUES( :ic_id, :title, :i, :im, :dd, :da)";

      return $this->db_connector->insert($this->query, $ass_params);
    }else if($this->uploadAttachment()){
       $file_info = pathinfo($_FILES["f_attach"]["name"]);
       $ass_params[":im"] = $_FILES["f_attach"]["name"];
       $this->query = "INSERT INTO assignment(ic_id, title, instruction, inst_material, due_date, date_available)
                      VALUES( :ic_id, :title, :i, :im, :dd, :da)";

       return $this->db_connector->insert($this->query, $ass_params);
    }else{
      return false;
    }
  }

  public function updateAssignment($ass_params){
    $this->query = "UPDATE assignment SET 
                    instruction = :i,
                    inst_material = :im,
                    due_date = :dd
                    WHERE assign_id = :ass_id";
    return $this->db_connector->update($this->query, $ass_params);
  }
  
  public function delAssignment($id){
    $this->query = "DELETE FROM assignment WHERE assign_id=?";
    return $this->db_connector->delete($this->query, array($id));
  }

  public function getSubmsns($ass_id){
    $query = "SELECT *
              FROM ass_submission 
              INNER JOIN studentcourserecord
                   ON studentcourserecord.scr_id = ass_submission.scr_id
              INNER JOIN students
                   ON students.IDNUMBER = studentcourserecord.IDNUMBER
              WHERE ass_submission.assign_id = ?
              ORDER BY date_submitted DESC";
    return $this->db_connector->select($query, array($ass_id))->fetchAll();
  }

  public function rate_sub($params){
    $query = "UPDATE ass_submission SET 
              rating = :rate,
              message = :msg 
              WHERE assign_sub_id = :sub_id";
    return $this->db_connector->update($query, $params);
  }

  public function get_ass($ass_id){	     
    $query = "SELECT assign_id, ic_id, instruction,
                     inst_material, 
                     date_format(due_date, '%m/%d/%Y') as due_date,
                     title
              FROM assignment WHERE assign_id = ?";
    return $this->db_connector->select($query, array($ass_id))->fetch();
  }

  private function uploadAttachment(){
    require_once '../../libraries/php/file_upload_download.php';
    $base_dir = "../../assignment_attachment/";
 
    $fud = new FileUploadDownload();

    if($fud->isValidFileType('f_attach')){
      $fud->uploadFile($base_dir, 'f_attach'); 
      return  true;
    }else{
      return false;
    }
  }

  
  
}

?>