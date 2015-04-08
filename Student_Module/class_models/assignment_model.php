<?php

require_once "../../libraries/proj_abs_cls/assignment.php";

class AssignmentModel extends Assignment{
  public function SCR_id($id,$ic_id){
    $this->query = "SELECT * 
                    studentcourserecord
                    WHERE ic_id=$ic_id
                    AND IDNUMBER=$id";
    return $this->db_connector->selectAll($this->query)->fetchAll();    
  }
  
  public function addAssignment($ass_params){
    if($this->uploadAttachment()){
       $file_info = pathinfo($_FILES["f_attach"]["name"]);
       $ass_params[":im"] = $_FILES["f_attach"]["name"];
       $this->query = "INSERT INTO assignment(ic_id, title, instruction, inst_material, due_date, date_available)
                      VALUES( :ic_id, :title, :i, :im, :dd, :da)";

       return $this->db_connector->insert($this->query, $ass_params);
    }else{
      return false;
    }
  }
  public function subAssignment($ass_params){
    if($this->uploadAttachment()){
       $file_info = pathinfo($_FILES["f_attach"]["name"]);
       $ass_params[":im"] = $_FILES["f_attach"]["name"];
       print_r($ass_params);
       echo $this->query = "INSERT INTO ass_submission(scr_id, assign_id, file_url, date_submitted)
                      VALUES( :scr_id, :assign_id,  :im, :ds)";
       
       return $this->db_connector->insert($this->query, $ass_params);
    }else{
      return false;
    }
  }
  public function isSubmitted($scr_id,$assign_id){
    $this->query = "SELECT * FROM ass_submission
                    WHERE  scr_id=$scr_id
                    AND assign_id=$assign_id";
    return $this->db_connector->doesExist($this->query);
  }

  public function isRate_viewed($scr_id,$assign_id){


    $this->query = "SELECT * FROM ass_submission
                    WHERE    scr_id=$scr_id
                    AND          assign_id=$assign_id
                    AND              is_viewRating=0
                    AND   rating>0";
    return $this->db_connector->doesExist($this->query);
  }

  public function updateRating($ass_params){
    $this->query = "UPDATE ass_submission
                   SET is_viewRating = 1
                       WHERE assign_id = :assign_id
                       AND scr_id = :scr_id";
    
    return $this->db_connector->update($this->query, $ass_params);
  }

  public function count_rated($scr_id){
    $this->query = "SELECT COUNT(*) FROM ass_submission
                    WHERE                  scr_id = $scr_id
                    AND                            is_viewRating = 0
                    AND                                    rating>0";
    
    return $this->db_connector->count($this->query);

  }


  public function getSubAssInfo($scr_id,$assign_id){
     $this->query = "SELECT * FROM ass_submission
                    WHERE  scr_id=$scr_id
                    AND assign_id=$assign_id";
     return $this->db_connector->selectAll($this->query)->fetchAll();
  }

  public function updateAssignment($ass_params){
    $this->query = "UPDATE assignment SET 
                    instruction = :i,
                    inst_material = :im,
                    due_date = :dd,
                    date_available = :da
                    WHERE assign_id = :id";
    return $this->db_connector->update($this->query, $ass_params);
  }
  
  public function delAssignment($id){
    $this->query = "DELETE FROM assignment WHERE assign_id=$id";
    return $this->db_connector->delete($this->query);
    
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