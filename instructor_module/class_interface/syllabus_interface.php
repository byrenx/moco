<?php
require_once '../../instructor_module/class_models/im_syllabus.php';

class SyllabusInterface{
  protected $IM_SYLLABUS;

  public function __construct(){
    $this->IM_SYLLABUS = new IMSyllabus();
  }

  //adding new chapter
  public function addNewChapter(){
    $title = sanitize($_POST['chapter']);

    if($this->IM_SYLLABUS->hasDuplicate($title,$_POST['icr_id'])){
      $title = urlencode($title);
      header("Location: ../../instructor_module/pages/syllabus.php?action=add&status=dup&title=$title");
    }else if($this->IM_SYLLABUS->addChapter()){
      $title = urlencode($title);
      header("Location: ../../instructor_module/pages/syllabus.php?action=add&status=ok&title=$title");
    }else{
      $title = urlencode($title);
      header("Location: ../../instructor_module/pages/syllabus.php?action=add&status=err&title=$title");
    }
  }
  
  public function showNewChapter(){
    $new_chapter = $this->IM_SYLLABUS->getNewChapter();
    $str_chapter = "<tr id='{$new_chapter['seq_no']}'>
                     <td>{$new_chapter['seq_no']}</td>
                     <td>{$new_chapter['title']}</td>
                     <td width='70px'>
                       <a href='javascript:deleteTopic(\"{$new_chapter['ch_id']}\",\"{$new_chapter['title']}\",\"#{$i}\");'
                         class='close' aria-hidden='true' title='Delete this Chapter'>&times
                       </a>
                       <a href='javascript:topicEditMode(\"{$new_chapter['seq_no']}\",
                                                          \"{$new_chapter['ch_id']}\")' title='Edit this Chapter'>
                         <img src='../../images/edit2.png'/>
                       </a> 
                       <a href='' title='Move Up'>
                         <img src='../../images/caret_up.png'>
                       </a>
                       <a href='Move Down'>
                         <img src='../../images/caret_down_gray.png'>
                       </a>
                     </td>
                    </tr>";
    echo $str_chapter;
  }
  
  //updating a selected chapter
  public function updateChapter(){
    $params = array(sanitize($_POST['chapter']),
                      $_POST['ch_id']);
   
    if($this->IM_SYLLABUS->hasDupBeforeUpdate($params[1], $params[0])){
      $params[0] = urlencode($params[0]);
      header("Location: ../../instructor_module/pages/syllabus.php?action=edit&status=dup&title={$params[0]}");
    }else if($this->IM_SYLLABUS->editChapter($params)){
      $params[0] = urlencode($params[0]);
      header("Location: ../../instructor_module/pages/syllabus.php?action=edit&status=ok&title={$params[0]}");
    }else{
      $params[0] = urlencode($params[0]);
      header("Location: ../../instructor_module/pages/syllabus.php?action=edit&status=err&title={$params[0]}");
    }
  }

  public function delChapter(){
    $this->IM_SYLLABUS->delChapter($_POST['ch_id'], $_POST['icr_id']);
  }

  public function moveUpSeq(){
    $this->IM_SYLLABUS->moveUpSeq($_POST['ch_id'], $_POST['icr_id'], $_POST['seq_no']);
  }

  public function moveDownSeq(){
    $this->IM_SYLLABUS->moveDownSeq($_POST['ch_id'], $_POST['icr_id'], $_POST['seq_no']);
  }
  
}//END OF CLASS

?>