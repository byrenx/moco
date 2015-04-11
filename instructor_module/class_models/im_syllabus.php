<?php

require_once '../../libraries/proj_abs_cls/syllabus.php';
require_once '../../libraries/php/sanitizer.php';

class IMSyllabus extends Syllabus{
 
  private $MB = 1048576;
  
  /******chapter functions*************/
  public function showEditChapter(){
    $params = array(sanitize($_POST['chapter']), $_POST['ch_id']);
    if($this->hasDupBeforeUpdate($params[1], $params[0])){
      echo 'err';
    }else{
      $this->editChapter($params);
      echo $params[0];
    }
  }
  
  public function addChapter(){
    $params = array(":id"=>$_POST['icr_id'],
                    ":ch"=>$_POST['chapter'],
                    ":seq"=>$_POST['ch_count']);

    $this->query = "INSERT INTO chapter
                    (ic_id, title, seq_no)
                    VALUES(:id, :ch, :seq)";
    return $this->db_connector->insert($this->query, $params);
  }

  public function editChapter($params){

    $this->query = "UPDATE chapter SET
                   title=?
                   WHERE ch_id=?";

    return $this->db_connector->update($this->query, $params);
  }

  public function delChapter($ch_id, $ic_id){
    /*
      $ch_id -> id of the chapter to be deleted
     */
    $ch_list = $this->selChFromCourse($ic_id);//fetch all chapters from a course
    $seq_no = $this->getChapterSeqno($ch_list, $ch_id);
    if($seq_no < count($ch_list)){
      $ch_list = $this->stackUpChFromSeq($ch_list, $seq_no);
      $this->batchChUpdate($ch_list);
    }
    $this->delChapterFromDb($ch_id);
  }

  public function delChapterFromDb($ch_id){
    $query = "DELETE FROM chapter WHERE ch_id=?";
    return $this->db_connector->delete($query, array($ch_id));
  }

  private function getChapterSeqno($ch_list, $ch_id){

    for($i=0; $i<count($ch_list); $i++){
      if($ch_list[$i]["ch_id"]==$ch_id){
	return $ch_list[$i]["seq_no"];
      }
    }

  }

  public function selChFromCourse($ic_id){
    /*
      $ic_id -> instructor course record id
                represenets a course teached by instructor
     */
    $query = "SELECT * FROM chapter WHERE ic_id=$ic_id ORDER BY seq_no ASC";
    return $this->db_connector->selectAll($query)->fetchAll();
  }

  public function stackUpChFromSeq($ch_list, $from_seq){
    if($from_seq==count($ch_list)){
      return $ch_list;
    }else{
      for($i = $from_seq; $i<count($ch_list); $i++){
	$ch_list[$i]["seq_no"] = $from_seq;
	$ch_list[$i][3] = $from_seq;
	$from_seq++;
      }
    }
    
    return $ch_list;
  }

  public function getTwoChfromSeq($ic_id, $seq1, $seq2){
    $query = "SELECT * FROM chapter WHERE ic_id=$ic_id
              AND (seq_no=$seq1 OR seq_no=$seq2) ORDER BY seq_no ASC";
    print $query;
    return $this->db_connector->selectAll($query)->fetchAll();
  }

  public function moveUpSeq($chapter_id, $ic_id, $seq_no){
    /*
      pre: $ic_id-> instructor curse record id
      move up 1 the sequence of a chapter in a specific 
      course handle by an instructor identified by $ic_id
      
     */
    $ch_list = $this->getTwoChFromSeq($ic_id, ($seq_no-1), $seq_no );//contains two chapters to be swap according to its sequence
    $ch_list = $this->swapChSeq( $ch_list, $seq_no-1, $seq_no);
    $this->batchChUpdate($ch_list);
  }

  public function moveDownSeq($chapter_id, $ic_id, $seq_no){
    /*
      pre: $ic_id-> instructor curse record id
      move down 1 the sequence of a chapter in a specific 
      course handle by an instructor identified by $ic_id
      
     */

    $ch_list = $this->getTwoChFromSeq($ic_id, $seq_no, $seq_no+1 );//contains two chapters to be swap according to its sequence
    $ch_list = $this->swapChSeq( $ch_list, $seq_no, $seq_no+1);
    $this->batchChUpdate($ch_list);
  }

  public function  swapChSeq($ch_list, $seq1, $seq2){
    $ch_list[0]["seq_no"] = $seq2;
    $ch_list[0][3] = $seq2;
    $ch_list[1]["seq_no"] = $seq1;
    $ch_list[1][3] = $seq1;
    return $ch_list;
  }

  public function batchChUpdate($ch_list){
    $query = "UPDATE chapter SET
              seq_no=? WHERE ch_id=?";
    foreach($ch_list AS $ch){
      $this->db_connector->update($query, array($ch['seq_no'], $ch['ch_id']));
    }
  }
  
  public function hasDuplicate($title, $icr_id){
    $this->query = "SELECT COUNT(*) FROM chapter
                    WHERE title='$title'
                    AND ic_id=$icr_id";

    return $this->db_connector->doesExist($this->query);
  }

  

  /*******public functions for lectures************/
  //lecture materials

  public function addMaterial(){
    /* this function upload a lecture material
     * and insert its info to the database
     */
    $upload_status = $this->uploadMaterial();
    if($upload_status==1){//uploading
      $file_info = pathinfo($_FILES['file_url']['name']);
      $allow_download = (isset($_POST['allow_download'])? 1 : 0);
      $q_params = array(
                    $_POST['lect_id'],
                    $_FILES['file_url']['name'],
		    $file_info['extension'],
		    $allow_download
                  );
    
      $this->query = "INSERT INTO lect_mat(lect_id, file_url, file_type, allow_download)
                     VALUES(?, ?, ?, ?)"; 

      $this->db_connector->insert($this->query, $q_params);
      return 1;
    }else if($upload_status==0){//file limit exceeded
      return 0;
    }else{//invalid file type
      return -1;
    }
  }

  public function getNewploadMaterial(){
    $this->query = "SELECT * FROM lect_mat
                   WHERE lectmat_id=(
                       SELECT MAX(lectmat_id)
                       FROM lect_mat)";
    return $this->db_connector->selectAll($this->query)->fetch();
  } 
  
  private function uploadMaterial(){
    /* return values:
       -1 : invalid file type
        0 : file limit exceeded
        1 : upload succesful
     */
    require_once '../../libraries/php/file_upload_download.php';
    $base_dir = "../../lecture_media_storage/";
 
    $fud = new FileUploadDownload();

    if($fud->isValidFileType('file_url')){
      $return_val = 1;
      if($fud->getFileSize('file_url') > (30 * $this->MB)){//134217728){
	print $fud->getFileSize('file_url');
	$return_val = 0;
      }else{
	if(!$fud->uploadFile($base_dir, 'file_url')){
	  print "Error: Uploading file failed.";
	  $return_val = 0;
	} 
      }
      return  $return_val;
    }else{
      return -1;
    }
  }

  //lecture materials
  
  public function getNewLecture(){
    $this->query = "SELECT * FROM lecture
                    WHERE lect_id=(
                          SELECT MAX(lect_id)
                          FROM lecture
                          )";
    return $this->db_connector->selectAll($this->query)->fetch();
  }

  
  public function addLecture($q_params){

    $this->query = "INSERT INTO lecture(tittle, ch_id)
                    VALUES(?,?)
                    ";
    return $this->db_connector->insert($this->query, $q_params);
  }

  public function isLectExist($lect_id, $chapter_id, $title){
    $result = false;
    $query = "SELECT * FROM lecture
              WHERE tittle=? AND ch_id=?";

    if($lect_id>0){//edit
      $query .=" AND lect_id<>?";
      $result = $this->db_connector->doesExistSelect($query, array($title, $chapter_id, $lect_id));
    }else{
      $result = $this->db_connector->doesExistSelect($query, array($title, $chapter_id));
    }
 
    return $result;
  }

  public function updateLecture($q_params){

    $this->query = "UPDATE lecture SET 
                    tittle=?,
                    ch_id=?
                    WHERE lect_id=?";
    return $this->db_connector->update($this->query, $q_params);
  }

  public function delLect($lect_id){//delete lecture identified by lecture id $lect_id
    
    $this->query = "DELETE FROM lecture WHERE lect_id=?";
    return $this->db_connector->delete($this->query, array($lect_id));
    
  }

  //chapters
  

  public function hasDupBeforeUpdate($id,$title){
    $this->query = "SELECT COUNT(*) FROM chapter
                    WHERE title='$title'
                    AND ch_id<>$id";
    return $this->db_connector->doesExist($this->query);
  }

  public function getNewChapter(){
    $this->query = "SELECT * FROM chapter
                    WHERE ch_id=(SELECT MAX(ch_id)
                    FROM chapter)";
    return $this->db_connector->selectAll($this->query)->fetch();
  }

  public function getLectureMaterial($lm_id){
    $query = "select * from lect_mat where lectmat_id = ?";
    return $this->db_connector->select($query, array($lm_id));
  }
  
  public function del_lm($lm_id){
    $query = "delete from lect_mat where lectmat_id=?";
    return $this->db_connector->delete($query, array($lm_id));
  }

  public function setDownloadable(){
    $mat_id = $_GET['mat_id'];
    $check = $_GET['check'];
    $query = "update lect_mat set allow_download=? where lectmat_id=?";
    $this->db_connector->update($query, array($check, $mat_id));
  }

}
?>              