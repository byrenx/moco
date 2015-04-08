<?php
require_once '../../instructor_module/class_models/im_syllabus.php';

class SyllabusInterface{
  protected $IM_SYLLABUS;

  public function __construct(){
    $this->IM_SYLLABUS = new IMSyllabus();
  }

  //adding new chapter
  public function addNewChapter(){
    $title = sanitize(sanitize($_POST['chapter']));

    if($this->IM_SYLLABUS->hasDuplicate($title,$_POST['icr_id'])){
      echo 'dup'; 
    }else if($this->IM_SYLLABUS->addChapter()){
      $this->showNewChapter();
    }else{
      echo 'err';
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
      echo 'dup';
    }else if($this->IM_SYLLABUS->editChapter($params)){
      echo $params[0];
    }else{
      echo "err";
    }
  }

  public function showNewItem($item_type){
    echo "<div>";
    echo "";
  }
  
  private function showMP(){
    echo "<div>";
      //header
      echo "<div>";
      echo "</div>";
      //content
      echo "<div>";
      echo "<form>";
       echo "<textare name='question' id='question'>";
       echo "<textarea>";
       echo "<label>Answer: </label>";
       echo "<select>";
       echo "<option value='A'>A</option>";
       echo "<option value='B'>B</option>";
       echo "<option value='C'>C</option>";
       echo "<option value='D'>D</option>";
       echo "</select>";
       echo "<label>Choices: </label>";
       echo "A<input type='text'>";
       echo "B<input type='text'>";
       echo "C<input type='text'>";
       echo "D<input type='text'>";
       echo "<input type='submit' value='Save'>";
       echo "<input type='submit' value='Cxancel'>";
      echo "</form>";
      echo "</div>";
    echo "</div>";
  }
}

?>